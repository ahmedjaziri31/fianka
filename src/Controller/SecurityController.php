<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\ResetPasswordFormType;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/{_locale}/forgot-password', name: 'app_forgot_password', defaults: ['_locale' => 'fr'], requirements: ['_locale' => 'en|fr'])]
    public function forgotPassword(
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        CsrfTokenManagerInterface $csrfTokenManager,
        TranslatorInterface $translator
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $csrfToken = $request->request->get('_csrf_token');

            // Validate CSRF token
            if (!$csrfTokenManager->isTokenValid(new \Symfony\Component\Security\Csrf\CsrfToken('forgot_password', $csrfToken))) {
                $this->addFlash('error', 'forgot_password.csrf_invalid');
                return $this->redirectToRoute('app_forgot_password', ['_locale' => $request->getLocale()]);
            }

            // Find user by email
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('error', 'forgot_password.email_not_found');
                return $this->redirectToRoute('app_forgot_password', ['_locale' => $request->getLocale()]);
            }

            // Generate a reset token
            $resetToken = bin2hex(random_bytes(32));
            $user->setResetToken($resetToken);

            // Set token expiry (e.g., 1 hour from now)
            $expiry = new \DateTime();
            $expiry->modify('+1 hour');
            $user->setResetTokenExpiry($expiry);

            // Persist the user with the token
            $entityManager->persist($user);
            $entityManager->flush();

            // Generate the reset link
            $resetLink = $this->generateUrl(
                'app_reset_password',
                ['token' => $resetToken, '_locale' => $request->getLocale()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            // Send email
            $emailMessage = (new Email())
                ->from('no-reply@fianka.com')
                ->to($user->getEmail())
                ->subject($translator->trans('forgot_password.email_subject'))
                ->html(
                    $this->renderView('emails/reset_password.html.twig', [
                        'reset_link' => $resetLink,
                        'user' => $user,
                    ])
                );

            $mailer->send($emailMessage);

            $this->addFlash('success', 'forgot_password.email_sent');
            return $this->redirectToRoute('app_login', ['_locale' => $request->getLocale()]);
        }

        return $this->render('security/forgot_password.html.twig');
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
public function resetPassword(string $token, Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
{
    $user = $userRepository->findOneBy(['resetToken' => $token]);

    // Check if the token is valid and not expired
    $invalidToken = !$user || ($user->getResetTokenExpiry() < new \DateTime());
    if ($invalidToken && $user) {
        // Clear the token if it's expired
        $user->setResetToken(null);
        $user->setResetTokenExpiry(null);
        $entityManager->persist($user);
        $entityManager->flush();
    }

    if (!$invalidToken) {
        $form = $this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the new password
            $newPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            // Clear the reset token
            $user->setResetToken(null);
            $user->setResetTokenExpiry(null);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Your password has been reset successfully.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig', [
            'resetForm' => $form->createView(),
            'invalid_token' => false,
            'user' => $user,
        ]);
    }

    return $this->render('security/reset_password.html.twig', [
        'invalid_token' => true,
        'user' => null,
    ]);
}
}

<?php

namespace App\EventListener;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Twig\Environment;

#[AsEventListener(event: 'kernel.request', priority: 100)]
class TwigEventListener
{
    private Environment $twig;
    private FormFactoryInterface $formFactory;

    public function __construct(Environment $twig, FormFactoryInterface $formFactory)
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
    }

    public function __invoke(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        // Form for pop-up
        $newsletterPopup = new Newsletter();
        $formPopup = $this->formFactory->create(NewsletterType::class, $newsletterPopup);
        $this->twig->addGlobal('form_newsletter_popup', $formPopup->createView());

        // Form for footer
        $newsletterFooter = new Newsletter();
        $formFooter = $this->formFactory->create(NewsletterType::class, $newsletterFooter);
        $this->twig->addGlobal('form_newsletter_footer', $formFooter->createView());
    }
}
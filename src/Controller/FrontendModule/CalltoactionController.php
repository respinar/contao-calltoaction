<?php

declare(strict_types=1);

/*
 * This file is part of Contao CTA Bundle.
 *
 * (c) Hamid Peywasti
 *
 * @license MIT
 */

namespace Respinar\CalltoactionBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(type: 'calltoaction', category: 'miscellaneous')]
class CalltoactionController extends AbstractFrontendModuleController
{
    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $page = $this->getPageModel();

        if (null === $page) {
            return new Response();
        }

        $trail = $this->getPageTrail($page);

        if (!$this->isCtaVisible($trail, $model)) {
            return new Response();
        }

        $ctaData = [
            'title' => null,
            'url' => null,
            'text' => null,
        ];

        foreach ($trail as $currentPage) {
            if (empty($ctaData['title']) && !\in_array(trim((string) $currentPage->ctaTitle), ['', '0'], true)) {
                $ctaData['title'] = $currentPage->ctaTitle;
            }

            if (empty($ctaData['url']) && !\in_array(trim((string) $currentPage->ctaUrl), ['', '0'], true)) {
                $ctaData['url'] = $currentPage->ctaUrl;
            }

            if (empty($ctaData['text']) && !\in_array(trim((string) $currentPage->ctaText), ['', '0'], true)) {
                $ctaData['text'] = $currentPage->ctaText;
            }

            if (!empty($ctaData['title']) && !empty($ctaData['url']) && !empty($ctaData['text'])) {
                break;
            }
        }

        $template->set('ctaTitle', $ctaData['title'] ?? $model->ctaTitle);
        $template->set('ctaUrl', $ctaData['url'] ?? $model->ctaUrl);
        $template->set('ctaText', $ctaData['text'] ?? $model->ctaText);

        $template->set('searchable', false);

        return $template->getResponse();
    }

    /**
     * @return array<PageModel>
     */
    private function getPageTrail(PageModel $page): array
    {
        $trail = [];
        while (null !== $page) {
            $trail[] = $page;
            $page = PageModel::findById($page->pid);
        }
        return $trail;
    }

    private function isCtaVisible(array $trail, ModuleModel $model): bool
    {
        foreach ($trail as $page) {
            $visibility = $page->ctaVisibility;

            if ('show' === $visibility) {
                return true;
            }

            if ('hide' === $visibility) {
                return false;
            }
        }

        return (bool) $model->ctaIsVisible;
    }
}

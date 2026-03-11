<?php

declare(strict_types=1);

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
        // Check if the current page has CTA fields set
        $page = $this->getPageModel();

        if (!$this->isCtaVisible($page, $model)) {
            return new Response();
        }

        $ctaData = [
            'title' => null,
            'url' => null,
            'text' => null,
        ];

        while (null !== $page) {
            // Set only if not already set and the page value is non-empty
            if (empty($ctaData['title']) && !\in_array(trim((string) $page->ctaTitle), ['', '0'], true)) {
                $ctaData['title'] = $page->ctaTitle;
            }

            if (empty($ctaData['url']) && !\in_array(trim((string) $page->ctaUrl), ['', '0'], true)) {
                $ctaData['url'] = $page->ctaUrl;
            }

            if (empty($ctaData['text']) && !\in_array(trim((string) $page->ctaText), ['', '0'], true)) {
                $ctaData['text'] = $page->ctaText;
            }

            // If all are filled, break
            if (!empty($ctaData['title']) && !empty($ctaData['url']) && !empty($ctaData['text'])) {
                break;
            }

            // If all values are found, break
            if ($ctaData['title'] && $ctaData['url'] && $ctaData['text']) {
                break;
            }

            // Move to parent
            $page = PageModel::findById($page->pid);
        }

        // Assign data to the template
        $template->set('ctaTitle', $ctaData['title'] ?? $model->ctaTitle);
        $template->set('ctaUrl', $ctaData['url'] ?? $model->ctaUrl);
        $template->set('ctaText', $ctaData['text'] ?? $model->ctaText);

        $template->set('searchable', false);

        return $template->getResponse();
    }

    private function isCtaVisible(PageModel $page, ModuleModel $model): bool
    {
        while (null !== $page) {
            $visibility = $page->ctaVisibility;

            if ('show' === $visibility) {
                return true;
            }

            if ('hide' === $visibility) {
                return false;
            }

            $page = PageModel::findById($page->pid);
        }

        return $model->ctaIsVisible;
    }
}

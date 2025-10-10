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

#[AsFrontendModule(category: "miscellaneous", type: "calltoaction")]
class CtaController extends AbstractFrontendModuleController
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

        while ($page !== null) {

            // Set only if not already set and the page value is non-empty
            if (empty($ctaData['title']) && !empty(trim((string)$page->ctaTitle))) {
                $ctaData['title'] = $page->ctaTitle;
            }

            if (empty($ctaData['url']) && !empty(trim((string)$page->ctaUrl))) {
                $ctaData['url'] = $page->ctaUrl;
            }

            if (empty($ctaData['text']) && !empty(trim((string)$page->ctaText))) {
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

        $template->set('searchable', False);

        return $template->getResponse();
    }

    private function isCtaVisible(PageModel $page, ModuleModel $model): bool
    {

        while ($page !== null) {
            $visibility = $page->ctaVisibility;

            if ($visibility === 'show') {
                return true;
            }

            if ($visibility === 'hide') {
                return false;
            }

            $page = PageModel::findById($page->pid);
        }

        return $model->ctaIsVisible;
    }
}

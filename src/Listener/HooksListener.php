<?php

declare(strict_types=1);

namespace Heimseiten\ContaoLinkWrapperBundle\Listener;

use Contao\FrontendTemplate;
use Contao\Template;
use Contao\Module;

use Contao\ContentModel;
use Contao\Widget;

class HooksListener
{
    public function onGetContentElement(ContentModel $element, string $buffer): string
    {
        return $this->processBuffer($buffer, $element);
    }

    private function processBuffer(string $buffer, $object): string
    {
        if (TL_MODE === 'BE' || !$object->linkWrapper) { return $buffer; }
        $openInNewWindow = '';
        if ($object->openInNewWindow) { $openInNewWindow = ' target="_blank" '; }

        $buffer = preg_replace('/class="([^"]+)"/', 'class="$1 wrapper_link"', $buffer, 1);
        $buffer = preg_replace('/<div/', '<a href="{{link_url::' . $object->linkWrapper . '}}"' . $openInNewWindow . ' style="text-decoration:none;"', $buffer, 1);
        $buffer = substr($buffer,0,-6);
        $buffer .= '</a>';

        return $buffer;
    }

}

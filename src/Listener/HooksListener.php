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
        $buffer = '<a href="{{link_url::' . $object->linkWrapper . '}}"' . $openInNewWindow . ' style="text-decoration:none;">' . $buffer . '</a>';
        return $buffer;
    }

}

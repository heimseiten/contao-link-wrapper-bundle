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
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')) || !$object->linkWrapper) { 
            return $buffer; 
        }
        $openInNewWindow = '';
        if ($object->openInNewWindow) { $openInNewWindow = ' target="_blank" '; }

        $buffer = preg_replace('/class="([^"]+)"/', 'class="$1 wrapper_link"', $buffer, 1);
        $buffer = preg_replace('/<div/', '<a href="' . $object->linkWrapper . '"' . $openInNewWindow . ' style="text-decoration:none;"', $buffer, 1);
        $buffer = preg_replace( '~(.*)</div>~su', '${1}</a>', $buffer);
        
        return $buffer;
    }

}

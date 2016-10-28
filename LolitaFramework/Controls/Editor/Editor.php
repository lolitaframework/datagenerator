<?php
namespace datagenerator\LolitaFramework\Controls\Editor;

use \datagenerator\LolitaFramework\Controls\Control;
use \datagenerator\LolitaFramework\Core\Arr;

class Editor extends Control
{
    /**
     * Render control
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     * @return string html code.
     */
    public function render()
    {
        $this->setAttributes(
            array_merge(
                $this->getAttributes(),
                array(
                    'name'                        => $this->getName(),
                    'data-customize-setting-link' => $this->getName(),
                )
            )
        );
        return parent::render();
    }
}

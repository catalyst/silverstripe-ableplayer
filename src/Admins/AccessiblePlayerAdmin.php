<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Admin\ModelAdmin;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

class AccessiblePlayerAdmin extends ModelAdmin
{
    private static $managed_models = [
        AccessibleVideo::class
    ];

    private static $menu_title = 'Accessible Videos';

    private static $url_segment = 'accessible';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        $grid = $form->Fields()->datafieldByName(
            $this->sanitiseClassName(
                $this->modelClass
            )
        );

        $grid->getConfig()
            ->removeComponentsByType(GridFieldAddNewButton::class)
            ->addComponent(
                (new GridFieldAddNewMultiClass())
                    ->setClasses([
                        SelfHostedVideo::class,
                        YouTube::class,
                        Vimeo::class
                    ])
            );


        return $form;
    }

}

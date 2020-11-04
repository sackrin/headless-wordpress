<?php

namespace App\Shared\Model;

use Fusion\Builder;
use Fusion\Field\File;
use Fusion\Field\Repeater;
use Fusion\Field\Tab;
use Fusion\Field\Text;
use Fusion\Field\Textarea;
use Fusion\Field\Wysiwyg;
use Fusion\FieldGroup;
use FusionModel\Type\OptionType;

class Options extends OptionType {

    /**
     * Define the WP post type
     * @var string
     */
    public static $optionGroup = 'about';

    public static function builder() {
        // code, label, options
        return (new Builder())
            ->addFieldGroup((new FieldGroup(static::$optionGroup.'_options', 'ABOUT SETTINGS'))
                ->setMenuOrder(2)
                ->addLocation('options_page', 'theme-config')
                ->addField((new Tab('about_description_tab', 'ABOUT DESCRIPTION')))
                ->addField((new Wysiwyg('about_description_header', 'Description Header')))
                ->addField((new Tab('about_points_tab', 'ABOUT POINTS')))
                ->addField((new Repeater('point_collection','Point List'))
                    ->addField((new Text('point_label','Point Label')))
                    ->addField((new Textarea('point_text','Point Text'))->setNewLines('br'))
                    ->setButtonLabel('Add New Tab')
                )
                ->addField((new Tab('about_tabular_tab', 'ABOUT TABS')))
                ->addField((new Repeater('tabular_collection','Tab List'))
                    ->addField((new Text('tab_label','Tab Label')))
                    ->addField((new Textarea('tab_text','Tab Text'))->setNewLines('br'))
                    ->setButtonLabel('Add New Tab')
                )
                ->addField((new Tab('about_faq_tab', 'ABOUT FAQ')))
                ->addField((new Repeater('faq_collection','FAQ List'))
                    ->addField((new Text('faq_label','FAQ Label')))
                    ->addField((new Textarea('faq_text','FAQ Text'))->setNewLines('br'))
                    ->setButtonLabel('Add New FAQ')
                )
                ->addField((new Tab('heroes_panels_tab', 'HERO PANELS')))
                ->addField((new Repeater('heroes_panel_collection','Hero Panel List'))
                    ->addField((new Wysiwyg('panel_text','Panel Text')))
                    ->addField((new File('panel_background', 'Panel Background'))
                        ->setReturnFormat('url'))
                    ->setButtonLabel('Add New Panel')
                    ->setMax(2)->setMin(2)
                )
            );
    }
}

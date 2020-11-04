<?php

namespace App\Page\Model;

use Fusion\Field\Image;
use Fusion\Field\PageLink;
use Fusion\Field\Taxonomy;
use Fusion\Field\Textarea;
use Fusion\Field\Wysiwyg;
use Fusion\FieldGroup;
use FusionModel\Type\PostType;
use Fusion\Builder;
use Fusion\Field\Text;
use Fusion\Field\Tab;
use Fusion\Field\Repeater;

class Page extends PostType {

    public static $post_defaults = [
        'post_title' => 'Page',
        'post_content' => 'Page Details',
        'post_excerpt' => 'Page Details',
        'post_type' => 'page',
        'post_status' => 'publish'
    ];

    public static $postType = 'page';

    public static function builder() {
        // code, label, options
        return (new Builder())
            ->addFieldGroup((new FieldGroup('page_settings', 'PAGE SETTINGS'))
                ->setPosition('acf_after_title')
                ->addLocation('post_type', static::$postType)
                ->addField(new Tab('meta','META'))
                ->addField((new Text('page_title', 'Page Title')))
                ->addField((new Textarea('page_description', 'Page Description'))->setWrapper(50))
                ->addField((new Textarea('page_keywords', 'Page Keywords'))
                    ->setWrapper(50)
                )
                ->addField(new Tab('security','SECURITY'))
                ->addField((new Taxonomy('security_authorised','Authorised'))
                    ->setReturnFormat('object')
                    ->setWrapper(50)
                )
                ->addField((new PageLink('security_redirect','Unauthorised Redirect'))
                    ->setWrapper(50)
                    ->setAllowArchives(0)
                    ->setPostType(['page'])
                )
                ->addField(new Tab('page_banners_tab','BANNERS'))
                ->addField((new Repeater('page_banners', 'Banner Collection'))
                    ->setButtonLabel('Add Page Banner')
                    ->setLayout('block')
                    ->addField((new Image('banner_background', 'Background Image'))->setWrapper(50))
                    ->addField((new Wysiwyg('banner_content', 'Content'))->setWrapper(50))
                )
            );
    }

}

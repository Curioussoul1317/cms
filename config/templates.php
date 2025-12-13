<?php

return [ 

 

'cards' => [
    'name' => 'Cards Grid',
    'description' => 'Display content in a grid of cards with gradient background',
    'icon' => 'ti ti-id',
    'fields' => [
        // Section Header
        ['name' => 'section_heading', 'label' => 'Section Heading', 'type' => 'text', 'required' => true],
        ['name' => 'section_subtitle', 'label' => 'Section Subtitle (Optional)', 'type' => 'text', 'required' => false],
        
        // Cards
        [
            'name' => 'cards',
            'label' => 'Cards',
            'type' => 'repeater',
            'fields' => [
                ['name' => 'svg_file', 'label' => 'SVG', 'type' => 'file', 'accept' => '.svg', 'required' => false],
                ['name' => 'heading', 'label' => 'Card Heading', 'type' => 'text', 'required' => true],
                ['name' => 'description', 'label' => 'Card Description', 'type' => 'textarea', 'required' => true],
            ]
        ]
    ]
],

'cards-grouped' => [
    'name' => 'Cards Grid (Grouped)',
    'description' => 'Display cards organized in collapsible groups',
    'icon' => 'ti ti-id',
    'fields' => [
        // Section Header
        ['name' => 'section_heading', 'label' => 'Section Heading', 'type' => 'text', 'required' => true],
        ['name' => 'section_subtitle', 'label' => 'Section Subtitle (Optional)', 'type' => 'text', 'required' => false],
        
        // Card Groups (Repeatable)
        [
            'name' => 'card_groups',
            'label' => 'Card Groups',
            'type' => 'repeater',
            'fields' => [
                ['name' => 'group_heading', 'label' => 'Group Heading', 'type' => 'text', 'required' => true],
                ['name' => 'group_description', 'label' => 'Group Description (Optional)', 'type' => 'text', 'required' => false],
                
                // Cards within each group (Nested Repeater)
                [
                    'name' => 'cards',
                    'label' => 'Cards in this Group',
                    'type' => 'repeater',
                    'fields' => [
                        ['name' => 'svg_file', 'label' => 'SVG', 'type' => 'file', 'accept' => '.svg', 'required' => false],
                        ['name' => 'heading', 'label' => 'Card Heading', 'type' => 'text', 'required' => true],
                        ['name' => 'description', 'label' => 'Card Description', 'type' => 'textarea', 'required' => true],
                    ]
                ]
            ]
        ]
    ]
],

'action-cards' => [
    'name' => 'Action Cards',
    'description' => 'Display action cards with icons and text',
    'icon' => 'ti ti-target',
    'fields' => [ 
        ['name' => 'section_heading', 'label' => 'Section Heading', 'type' => 'text', 'required' => true],
     
        [
            'name' => 'cards',
            'label' => 'Action Cards',
            'type' => 'repeater',
            'fields' => [
                ['name' => 'svg_file', 'label' => 'SVG Icon', 'type' => 'file', 'accept' => '.svg', 'required' => false],
                ['name' => 'text', 'label' => 'Card Text', 'type' => 'text', 'required' => true],
                ['name' => 'link_url', 'label' => 'Link URL (Optional)', 'type' => 'url', 'required' => false],
            ]
        ]
    ]
],

'hero_with_image' => [
    'name' => 'Hero Section with Image',
    'description' => 'Hero banner with content and side image',
    'icon' => 'ti ti-layout-2',
    'fields' => [
        ['name' => 'background_color', 'label' => 'Background Color', 'type' => 'text', 'required' => false, 'placeholder' => '#4DD0E1'],
        ['name' => 'title', 'label' => 'Main Heading', 'type' => 'text', 'required' => true],
        ['name' => 'subtitle', 'label' => 'Subtitle/Price', 'type' => 'text', 'required' => false],
        ['name' => 'button_text', 'label' => 'Button Text', 'type' => 'text', 'required' => false],
        ['name' => 'button_link', 'label' => 'Button Link', 'type' => 'text', 'required' => false],
        ['name' => 'image', 'label' => 'Side Image', 'type' => 'file', 'required' => false],
    ]
],

'hero' => [
    'name' => 'Hero Section',
    'description' => 'Large banner with title and call-to-action',
    'icon' => 'ti ti-badge',
    'fields' => [
        ['name' => 'title', 'label' => 'Announcement Text', 'type' => 'text', 'required' => true],
        ['name' => 'subtitle', 'label' => 'Main Heading', 'type' => 'text', 'required' => false],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
        ['name' => 'terms', 'label' => 'Terms & Conditions', 'type' => 'text', 'required' => false],
    ]
],

'gallery' => [
    'name' => 'Image Gallery',
    'description' => 'Display images in a beautiful gallery',
    'icon' => 'ti ti-photo',
    'fields' => [
        [
            'name' => 'images',
            'label' => 'Images',
            'type' => 'repeater',
            'fields' => [
                ['name' => 'image', 'label' => 'Image URL', 'type' => 'url', 'required' => true],
                ['name' => 'caption', 'label' => 'Caption', 'type' => 'text', 'required' => false],
            ]
        ]
    ]
],

'text-section' => [
    'name' => 'Text Section',
    'description' => 'Rich text content section',
    'icon' => 'ti ti-file-text',
    'fields' => [
        ['name' => 'heading', 'label' => 'Heading', 'type' => 'text', 'required' => true],
        ['name' => 'subheading', 'label' => 'Subheading', 'type' => 'text', 'required' => false],
        ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'required' => true],
    ]
],

'features' => [
    'name' => 'Features Grid',
    'description' => 'Highlight features or services',
    'icon' => 'ti ti-star',
    'fields' => [
        ['name' => 'section_title', 'label' => 'Section Title', 'type' => 'text', 'required' => false],
        [
            'name' => 'features',
            'label' => 'Features',
            'type' => 'repeater',
            'fields' => [
                ['name' => 'icon', 'label' => 'Icon/Emoji', 'type' => 'text', 'required' => false],
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
            ]
        ]
    ]
],

'cta' => [
    'name' => 'Call to Action',
    'description' => 'Eye-catching call to action section',
    'icon' => 'ti ti-speakerphone',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
        ['name' => 'button_text', 'label' => 'Button Text', 'type' => 'text', 'required' => true],
        ['name' => 'button_url', 'label' => 'Button URL', 'type' => 'url', 'required' => true],
        ['name' => 'background_color', 'label' => 'Background Color', 'type' => 'color', 'required' => false],
    ]
],

'video' => [
    'name' => 'Video Embed',
    'description' => 'Embed YouTube or Vimeo videos',
    'icon' => 'ti ti-video',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => false],
        ['name' => 'video_url', 'label' => 'Video URL (YouTube or Vimeo)', 'type' => 'url', 'required' => true],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
    ]
],

'steps' => [
    'name' => 'Steps Timeline',
    'description' => 'Display process steps in an alternating timeline layout',
    'icon' => 'ti ti-stairs',
    'fields' => [
        ['name' => 'section_title', 'label' => 'Section Title (Optional)', 'type' => 'text', 'required' => false],
        ['name' => 'section_description', 'label' => 'Section Description (Optional)', 'type' => 'textarea', 'required' => false],
        [
            'name' => 'steps',
            'label' => 'Steps',
            'type' => 'repeater',
            'fields' => [
                ['name' => 'heading', 'label' => 'Step Heading', 'type' => 'text', 'required' => true],
                ['name' => 'description', 'label' => 'Step Description', 'type' => 'textarea', 'required' => true],
                ['name' => 'link_text', 'label' => 'Link Text (Optional)', 'type' => 'text', 'required' => false],
                ['name' => 'link_url', 'label' => 'Link URL (Optional)', 'type' => 'url', 'required' => false],
                ['name' => 'svg_file', 'label' => 'SVG Illustration', 'type' => 'file', 'accept' => '.svg', 'required' => false],
            ]
        ]
    ]
],

'product-detail' => [
    'name' => 'Product Detail',
    'description' => 'Display product/service with image, pricing table, and downloadable files',
    'icon' => 'ti ti-package',
    'fields' => [
        ['name' => 'image', 'label' => 'Product Image', 'type' => 'file', 'required' => true, 'accept' => 'image/*'],
        ['name' => 'icon', 'label' => 'Icon/Emoji  ', 'type' => 'text', 'required' => false],
        ['name' => 'heading', 'label' => 'Main Heading', 'type' => 'text', 'required' => true],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => true],
        ['name' => 'table_heading', 'label' => 'Table Heading (e.g., "Pricing Details")', 'type' => 'text', 'required' => false],
        ['name' => 'unit_label', 'label' => 'Unit (e.g., "Per Month", "Per User")', 'type' => 'text', 'required' => true],
        ['name' => 'rate_value', 'label' => 'Rate (e.g., "$99", "Free")', 'type' => 'text', 'required' => true],
        ['name' => 'table_note', 'label' => 'Note Below Table (Small text)', 'type' => 'text', 'required' => false],
        ['name' => 'document_heading', 'label' => 'Document Heading (e.g., "Product Brochure")', 'type' => 'text', 'required' => false],
        ['name' => 'document_file', 'label' => 'Upload Document File', 'type' => 'file', 'required' => false, 'accept' => '.pdf,.doc,.docx,.xls,.xlsx'],
        ['name' => 'document_button_text', 'label' => 'Download Button Text', 'type' => 'text', 'required' => false],
    ]
],

];
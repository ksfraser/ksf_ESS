<?php

function ksf_ess_import_handler()
{
    add_shortcode('ksf_ess_import', function($atts) {
        $atts = shortcode_atts([
            'type' => 'employee',
        ], $atts);
        
        $target_fields = match($atts['type']) {
            'employee' => ['emp_no', 'first_name', 'last_name', 'email', 'phone'],
            'timesheet' => ['emp_no', 'date', 'hours', 'project', 'task'],
            default => ['id', 'name'],
        };
        
        $ui = ImportUI::create([
            'module' => 'ess_' . $atts['type'],
            'target_fields' => $target_fields,
        ]);
        
        return $ui->renderShortcode($target_fields, 'ess_' . $atts['type']);
    });
}

add_action('init', 'ksf_ess_import_handler');
<?php
/*
 * Copyright (c) 2025 AltumCode (https://altumcode.com/)
 *
 * This software is licensed exclusively by AltumCode and is sold only via https://altumcode.com/.
 * Unauthorized distribution, modification, or use of this software without a valid license is not permitted and may be subject to applicable legal actions.
 *
 * 🌍 View all other existing AltumCode projects via https://altumcode.com/
 * 📧 Get in touch for support or general queries via https://altumcode.com/contact
 * 📤 Download the latest version via https://altumcode.com/downloads
 *
 * 🐦 X/Twitter: https://x.com/AltumCode
 * 📘 Facebook: https://facebook.com/altumcode
 * 📸 Instagram: https://instagram.com/altumcode
 */

namespace Altum\Models;

defined('ALTUMCODE') || die();

class Tools extends Model {

    public function get_tools_usage() {

        $cache_instance = cache()->getItem('tools_usage');

        /* Set cache if not existing */
        if(!$cache_instance->get()) {

            $result = database()->query("SELECT * FROM `tools_usage` ORDER BY `total_views` DESC");
            $data = [];

            while($row = $result->fetch_object()) {
                $row->data = json_decode($row->data ?? '');
                $data[$row->tool_id] = $row;
            }

            cache()->save($cache_instance->set($data)->expiresAfter(3600));

        } else {

            /* Get cache */
            $data = $cache_instance->get('tools_usage');

        }

        return $data;
    }

    public function process_usage($tool_id, $input = null, $data = []) {
        $tool_usage = db()->where('tool_id', $tool_id)->getOne('tools_usage');

        $data_key = $input ? md5(serialize($input)) : null;

        if($tool_usage) {
            $tool_usage->data = json_decode($tool_usage->data ?? '', true);

            if(!is_array($tool_usage->data)) {
                $tool_usage->data = [];
            }

            if($input) {
                $tool_usage->data[$data_key] = array_merge($input, (array)$data);
                $tool_usage->data = array_reverse($tool_usage->data);
                $tool_usage->data = array_slice($tool_usage->data, 0, 10);
            }

            db()->where('tool_id', $tool_id)->update('tools_usage', [
                'total_submissions' => db()->inc(),
                'data' => json_encode($tool_usage->data),
            ]);
        }

        else {
            $data = $input ? array_merge([
                $data_key => $input,
            ], (array) $data) : [];

            db()->insert('tools_usage', [
                'tool_id' => $tool_id,
                'total_views' => 1,
                'total_submissions' => 1,
                'data' => json_encode($data),
            ]);
        }

    }
}

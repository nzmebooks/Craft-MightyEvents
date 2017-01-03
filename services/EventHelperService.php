<?php

namespace Craft;

/**
 * EventHelper service.
 *
 * Handles common export logics.
 */
class EventHelperService extends BaseApplicationComponent
{

    /**
     * Download the export csv.
     *
     * @param array $settings
     *
     * @return string
     *
     * @throws Exception
     */
    public function download()
    {
        // Get max power
        craft()->config->maxPowerCaptain();

        // Get delimiter
        $delimiter = ',';

        // Get data
        $service = new EventHelper_AttendeesService();
        $data = $service->getAttendeesForCsv();

        // Open output buffer
        ob_start();

        // Write to output stream
        $export = fopen('php://output', 'w');

        // If there is data, process
        if (is_array($data) && count($data)) {

            // Loop through data
             foreach ($data as $fields) {

                // Gather row data
                $rows = array();

                // Loop through the fields
                foreach ($fields as $field) {

                    // Encode and add to rows
                    $rows[] = StringHelper::convertToUTF8($field);
                }

                // Add rows to export
                fputcsv($export, $rows, $delimiter);
            }
        }

        // Close buffer and return data
        fclose($export);
        $data = ob_get_clean();

        // Use windows friendly newlines
        $data = str_replace("\n", "\r\n", $data);

        // Return the data to controller
        return $data;
    }

}

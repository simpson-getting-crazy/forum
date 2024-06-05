<?php

namespace App\Actions;

class ProcessEditorFileUpload
{
    public static function make(string $content): object
    {
        if (str_contains($content, 'img')) {
            $dom = new \DomDocument();
            $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                $data = $image->getAttribute('src');
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $imageData = base64_decode($data);
                $imageName = "/forum/thread-content-files/" . time() . $item . '.png';
                $path = public_path() . $imageName;

                if (!file_exists(public_path('forum/thread-content-files/'))) {
                    mkdir(public_path('forum/thread-content-files/'), 755, true);
                }

                file_put_contents($path, $imageData);

                $image->removeAttribute('src');
                $image->setAttribute('src', $imageName);
            }

            $content = str_replace($imageName, url($imageName), $dom->saveHTML());
        }

        return (object) [
            'value' => $content,
        ];
    }
}

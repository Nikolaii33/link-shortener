<?php

const FILE_NAME = 'data.txt';

function getLinkByToken(string $token): string{
    if (checkFile()) {
        $allLinks = json_decode(file_get_contents(FILE_NAME), true) ?? [];
        foreach ($allLinks as $link) {
            if ($link['token'] === $token) {
                return $link['link'];
            }
        }
    }
   return '';
}

function checkFile(): bool {
    return file_exists(FILE_NAME);
}

function checkUrl($url) {
    if (checkFile()) {
        $allLinks = json_decode(file_get_contents(FILE_NAME), true) ?? [];
        foreach ($allLinks as $link) {
            if ($link['link'] === $url) {
                return $link;
            }
        }
    }
    return false;
}

function updateLink($token) {
    $allLinks = json_decode(file_get_contents(FILE_NAME), true) ?? [];
    foreach ($allLinks as $key => $link) {
        if ($link['token'] === $token) {
            $allLinks[$key]['transition']++;
        }
    }
    file_put_contents(FILE_NAME, json_encode($allLinks, JSON_UNESCAPED_SLASHES));
}

function generateToken(): string {
    $chars = 'abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ0123456789';
    $arrChars = str_split($chars);
    $token = '';
    for ($i = 0; $i < 8; $i++) {
        $token .= $arrChars[mt_rand(0, count($arrChars) - 1)];
    }
    return $token;
}

function saveLink($link) {
    if (!checkUrl($link)) {
        $allLinks = json_decode(file_get_contents(FILE_NAME));
        $newLink = [
            'link' => $link,
            'token' => generateToken(),
            'transition' => 0,
        ];
        $allLinks[] = $newLink;
        file_put_contents(FILE_NAME, json_encode($allLinks, JSON_UNESCAPED_SLASHES));
        return $newLink;
    }
    return false;
}

<?php

// *~*~*~*~*~*~* MOOD ICON IMAGES *~*~*~*~*~*~*

function getMoodIcon(string $moodCategory): string {
    switch (trim($moodCategory)) {
        case 'Blooming':
            return BASE_URL . 'assets/images/categories/Blooming.png';
        case 'Rooted':
            return BASE_URL . 'assets/images/categories/Rooted.png';
        case 'Wilted':
            return BASE_URL . 'assets/images/categories/Wilted.png';
        case 'Prickly':
            return BASE_URL . 'assets/images/categories/Prickly.png';
        default:
            return '';
    }
}
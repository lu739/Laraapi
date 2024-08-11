<?php

namespace App\Enum;

enum ProductStatus: string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
}

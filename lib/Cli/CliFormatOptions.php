<?php

declare(strict_types=1);


namespace Therion86\Framework\Cli;

enum CliFormatOptions: int
{
    case BOLD = 1;
    case ITALIC = 3;
    case UNDERLINE = 4;
    case STRIKE = 9;


    case COLOR_BLACK = 30;
    case COLOR_RED = 31;
    case COLOR_GREEN = 32;
    case COLOR_YELLOW = 33;
    case COLOR_BLUE = 34;
    case COLOR_PURPLE = 35;
    case COLOR_CYAN = 36;
    case COLOR_WHITE = 37;

}
<?php

namespace Therion86\Framework\Cli;


enum CliColor: string
{
    case BLACK = "\033[0;30m";
    case RED = "\033[0;31m";
    case GREEN = "\033[0;32m";
    case YELLOW = "\033[0;33m";
    case BLUE = "\033[0;34m";
    case PURPLE = "\033[0;35m";
    case CYAN = "\033[0;36m";
    case WHITE = "\033[0;37m";
}
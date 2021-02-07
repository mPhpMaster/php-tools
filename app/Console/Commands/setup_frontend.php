<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class setup_frontend
 *
 * @package App\Console\Commands
 */
class setup_frontend extends Command
{
    /**
     * @var string[]
     */
    static $all_commands = [
        "bootstrap" => "ui bootstrap",
        "vue" => "ui vue",
        "react" => "ui react"
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:frontend';
    /**
     * @var array
     */
    protected $_aliases = [

    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '<error><comment>[hlaCk]</comment> Scaffold New View.</error>';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Configure the command options.
     *<comment>
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setAliases($this->_aliases)
            ->setDescription($this->description)
//            ->addUsage($this->name . " bootstrap --auth\tGenerate login / registration scaffolding via bootstrap")
            ->addArgument('type', InputArgument::OPTIONAL, 'Scaffolding Type.', null)
            ->addOption('auth', 'A', InputOption::VALUE_NONE, 'Build with authentication scaffolding')
            ->addOption('list', 'l', InputOption::VALUE_NONE, 'Show scaffolding types');
    }

    /**
     * @return array
     */
    public function getExample()
    {
        return collect(self::$all_commands)->map(function ($a, $v) {
            return "php artisan {$this->name} {$v} --auth\tGenerate login / registration scaffolding via {$v}";
        })->toArray();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');
        if ( $input->getOption('list') || is_null($type) ) {
            $this->showLists($input, $output);
            return 0;
        }

        $command = self::$all_commands[ $type ] ?? false;
        if ( $command === false ) {
            throw new LogicException('You must Choose type.');
        }
        $command = explode(" ", $command);
        $_args = ["type" => last($command)];
        $command = head($command);

        if ( $input->getOption('auth') ) {
            $_args[] = ["auth" => true];
        }

        $output->writeln("Run [{$command} {$_args['type']}" . ($input->getOption('auth') ? " --auth" : "") . "] ...");

        return $this->call($command, $_args);
    }

    /**
     * Execute the command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function showLists(InputInterface $input, OutputInterface $output)
    {
        $this->table([
            ($this->styleText(
                "Type",
                ($this->getColorText("green") . ";" . $this->getColorBackground("default"))
            )),
            ($this->styleText(
                "Usage",
                ($this->getColorText("green") . ";" . $this->getColorBackground("default"))
            )),
            ($this->styleText(
                "Description",
                ($this->getColorText("green") . ";" . $this->getColorBackground("default"))
            ))
        ], collect($this->getExample())
            ->map(function ($v, $k) {
                return explode("\t", $v);
            })
            ->map(function ($v) use ($input, $output) {
                return [
                    $this->styleText(
                        explode(" ", head($v))[3],
                        ($this->getColorText("default") . ";" . $this->getColorBackground("default"))
                    ),
                    $this->styleText(
                        head($v),
                        ($this->getColorText("default") . ";" . $this->getColorBackground("default"))
                    ),
                    $this->styleText(
                        last($v),
                        ($this->getColorText("cyan") . ";" . $this->getColorBackground("default"))
                    )
                ];
            }), 'box');

        return 0;
    }


    /**
     * Execute the console command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->handle($input, $output);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \Symfony\Component\Console\Style\SymfonyStyle
     */
    public function getStyler(InputInterface $input, OutputInterface $output)
    {
        return new SymfonyStyle($input, $output);
    }

    /**
     * @param string $string
     * @param string $type
     *
     * @return string
     */
    private function styleText($string, $type = "")
    {
        /** @var string|null $_type */
        if ( $type && stripos($type, '=') === false ) {
            $_type = $type && ($__type = (string)$this->getTextTypes($type)) ? (string)$__type : null;
            $_type = is_null($_type) && ($__type = (string)$this->getColorText($type)) ? (string)$__type : $type;
            $_type = $_type ? $_type : null;
        } else {
            $_type = $type;
        }
        $_string = (string)(is_null($_type) ? $string : sprintf('<%s>%s</>', $_type, $string));
//        $string = !$type ? sprintf('<%s>%s</>', $type , $string) : $string;
        return $_string;
    }

    /**
     *
     */
    const STYLES_TYPES = [
        'SUCCESS' => 'success',
        'COMMENT' => 'comment',
        'ERROR' => 'error',
        'WARNING' => 'warning',
        'NOTE' => 'note',
        'CAUTION' => 'caution',
    ];

    /**
     * @param string|null $type
     *
     * @return string|mixed
     */
    private function getTextTypes($type = null)
    {
        $type = $type ? trim(strtolower($type)) : $type;
        $type = $type && $type === 'default' ? 'comment' : $type;

        $types = [
            'comment' => '<fg=default;bg=default> // </>',
            'success' => 'fg=black;bg=green',
            'error' => 'fg=white;bg=red',
            'warning' => 'fg=black;bg=yellow',
            'note' => 'fg=yellow',
            'caution' => 'fg=white;bg=red'
        ];
        if ( $type ) {
            $_types = array_search($type, $types);
            $_types = $_types === false ? array_search($type, array_combine(array_keys($types), array_keys($types))) : $_types;
        } else {
            $_types = $types;
        }

        return $_types ? $types[ $_types ] : null;
    }

    /**
     *
     */
    const TEXT_COLORS = [
        "BLACK" => "black",
        "RED" => "red",
        "GREEN" => "green",
        "YELLOW" => "yellow",
        "BLUE" => "blue",
        "MAGENTA" => "magenta",
        "CYAN" => "cyan",
        "WHITE" => "white",
        "DEFAULT" => "default"
    ];

    /**
     * @param string $color
     *
     * @return string
     */
    private function getColorText($color = "default")
    {
        $color = trim(strtoupper($color));

        $_color = self::TEXT_COLORS[ $color ] ?? self::TEXT_COLORS["DEFAULT"];
        return "fg={$_color}";
    }

    /**
     * @param string $color
     *
     * @return string
     */
    private function getColorBackground($color = "default")
    {
        $color = trim(strtoupper($color));

        $_color = self::TEXT_COLORS[ $color ] ?? self::TEXT_COLORS["DEFAULT"];
        return "bg={$_color}";
    }
}

<?php

namespace Modules\Artisany\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Artisan;
use Exception;
use Modules\Artisany\Http\Kernel;

class ArtisanyController extends \AppController
{
	/**
	 * Create a new ArtisanyController controller instance.
	 *
	 * @return void
	 */
	public function __construct(Kernel $kernel)
	{
		if(($middleware = collect(config('artisany.middleware', [])))->isNotEmpty()) {
			$middleware->each(function ($v) {
				$this->middleware($v);
			});
		}
	}
	
	/**
	 * Show the commands.
	 *
	 * @return Response
	 */
	public function show($option = null)
	{
		$this->getArtisanCommands();
		$options = array_keys(config('artisany.commands', []));
		array_push($options, 'customs');
		
		if (is_null($option)) {
			$option = array_values($options)[0];
		}
		
		if (!in_array($option, $options)) {
			abort(404);
		}
		
		if ($option == 'customs') {
			$items = array_diff_key($this->getArtisanCommands(), array_flip(config('artisany.coreCommands.', [])));
		} else {
			$items = array_intersect_key(
							$this->getArtisanCommands(),
							array_flip(config('artisany.commands.' . $option, []))
			);
		}
//		d(
//			$options,
//			config('artisany.commands', [])
//		);
		return view('artisany::index', compact('items', 'options'));
	}
	
	private function getArtisanCommands() {
		$cmds = Artisan::all();
		foreach ($cmds as $cmdName=>$cmdClass) {
//			if ($cmdName == 'myth:install') {
				if (method_exists($cmdClass, 'getArtisanyType')) {
					$newType = $cmdClass->getArtisanyType();
					config([
						'artisany.commands.' . $newType=>array_merge(
										config('artisany.commands.' . $newType, []),
										[$cmdName]
									)
					]);
				}
//			}
		}
		return $cmds;
	}
	
	/**
	 * Call the Artisan  command
	 *
	 * @param  Request  $request
	 * @param  string $command
	 */
	public function command(Request $request, $command)
	{
		if (array_key_exists('argument_name', $request->all())) {
			$this->validate($request, ['argument_name' => 'required']);
		}
		
		if (array_key_exists('argument_id', $request->all())) {
			$this->validate($request, ['argument_id' => 'required']);
		}
		
		$inputs = $request->except('_token', 'command');
		
		$params = [];
		foreach ($inputs as $key => $value) {
			if ($value != '') {
				$name = starts_with($key, 'argument') ? substr($key, 9) : '--' . substr($key, 7);
				$params[$name] = $value;
			}
		}
		
		try {
			Artisan::call($command, $params);
		} catch (Exception $e) {
			return back()->with('error', $e->getMessage());
		}
		
		return back()->with('output', Artisan::output());
	}
	
}

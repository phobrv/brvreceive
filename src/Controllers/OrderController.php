<?php

namespace Phobrv\BrvReceive\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\BrvCore\Repositories\ReceiveDataRepository;
use Phobrv\BrvCore\Repositories\UserRepository;
use Phobrv\BrvCore\Services\UnitServices;

class OrderController extends Controller {
	protected $receiveRepository;
	protected $userRepository;
	protected $unitService;
	protected $type;

	public function __construct(
		ReceiveDataRepository $receiveRepository,
		UserRepository $userRepository,
		UnitServices $unitService
	) {
		$this->userRepository = $userRepository;
		$this->receiveRepository = $receiveRepository;
		$this->unitService = $unitService;
		$this->type = config('option.receive_type.order');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = Auth::user();
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Orders', 'href' => ''],
			]
		);
		try {
			$data['select'] = $this->userRepository->getMetaValueByKey($user, 'order_select');
			$arrayWhere = ['type' => 'order'];
			if ($data['select'] != "0") {
				$arrayWhere['status'] = $data['select'];
			}
			$data['orders'] = $this->receiveRepository->orderBy('created_at', 'desc')->findWhere($arrayWhere);
			if (count($data['orders'])) {
				$number = 0;
				for ($i = 0; $i < count($data['orders']); $i++) {
					$metas = $data['orders'][$i]->receiveDataMetas;
					$number = $metas->where('key', 'number')->first();
				}

			}
			return view('phobrv::order.index')->with('data', $data);

		} catch (Exception $e) {

		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Orders', 'href' => ''],
				['text' => 'Edit', 'href' => ''],
			]
		);
		try {
			$data['post'] = $this->receiveRepository->find($id);
			$meta = $data['post']->receiveDataMetas;
			return view('phobrv::order.edit')->with('data', $data);

		} catch (Exception $e) {

		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$data = $request->all();
		$receive = $this->receiveRepository->update($data, $id);
		return redirect()->route('order.index')->with('alert_success', 'Cập nhật đơn hàng thành công');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		// $this->receiveRepository->destroy($id);
		$receive = $this->receiveRepository->update(['status' => 'fail'], $id);
		$msg = __("Delete post success!");
		return redirect()->route('order.index')->with('alert_success', $msg);

	}
	/**
	 * Set default order type select
	 */
	public function setDefaultSelect(Request $request) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, array('order_select' => $request->select));
		return redirect()->route('order.index');
	}
}

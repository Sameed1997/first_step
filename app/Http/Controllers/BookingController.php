<?php

namespace DTApi\Http\Controllers;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers
 */
class BookingController extends Controller
{

    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * BookingController constructor.
     * @param BookingRepository $bookingRepository
     */
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->repository = $bookingRepository;
    }

    /**
     * Retrieve all jobs for the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $jobs = $this->repository->getUsersJobs($request);

        return response()->json($jobs);
    }

    /**
     * Store a new job.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $job = $this->repository->store($data);
            return response()->json(['success' => true, 'job' => $job], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Show a specific job by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $job = $this->repository->find($id);

        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Job not found'], 404);
        }

        return response()->json(['success' => true, 'job' => $job]);
    }

    /**
     * Update a specific job by ID.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $data = $request->all();

        try {
            $job = $this->repository->update($id, $data);

            if (!$job) {
                return response()->json(['success' => false, 'message' => 'Job not found'], 404);
            }

            return response()->json(['success' => true, 'job' => $job]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Delete a specific job by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $deleted = $this->repository->delete($id);

            if (!$deleted) {
                return response()->json(['success' => false, 'message' => 'Job not found'], 404);
            }

            return response()->json(['success' => true, 'message' => 'Job deleted']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }
}

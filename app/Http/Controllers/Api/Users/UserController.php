<?php

namespace App\Http\Controllers\Api\Users;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use GenderApi\Client as GenderApiClient;

/**
 * User API controller.
 *
 * @author Erik Galloway <erik@fliplearning.com>
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Gender\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request, GenderApiClient $client)
    {
        $query = $this->getGenderApiResponse($client, $request);

        if ($query->getAccuracy() < 70 && ! $request->has('gender')) {
            return $this->sendGenderAccuracyResponse();
        }

        $user = User::create($this->getUserData($request, $query));

        return response()->json([
            'message' => 'Success! The user was registered successfully.',
            'data'    => $user->toArray(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \App\User
     */
    public function show($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => 'The user was not found.',
            ], 404);
        }

        return $user;
    }

    /**
     * Get the gender-api response data.
     *
     * @param \GenderApi\Client $client
     * @param \Illuminate\Http\Request $request
     * @return \GenderApi\Client\Result\Split
     */
    protected function getGenderApiResponse(GenderApiClient $client, Request $request)
    {
        if ($request->country) {
            return $client->getByFirstNameAndLastNameAndCountry($request->name, $request->country);
        }

        return $client->getByFirstNameAndLastName($request->name);
    }

    /**
     * Get the data used to create a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \GenderApi\Client\Result\Split $query
     * @return array
     */
    protected function getUserData(Request $request, $query): array
    {
        $data = [
            'email'      => $request->email,
            'first_name' => $query->getFirstName(),
            'last_name'  => $query->getLastName(),
            'gender'     => $request->has('gender') ? $request->gender : $query->getGender(),
        ];

        $names = collect(explode(' ', $request->name));

        if ((! $query->getFirstName() && $names->count() >= 2) || $names->count() > 2) {
            $data['first_name'] = $names->first();
            $names->forget(0);
            $data['last_name'] = $names->implode(' ');
        }

        return $data;
    }

    /**
     * Send the gender accuracy error response.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendGenderAccuracyResponse()
    {
        return response()->json([
            'message' => 'Sorry! We still need more information.',
            'errors'  => [
                'gender' => ['Please select a gender.'],
            ],
            ], 422);
    }
}

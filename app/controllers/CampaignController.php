<?php

class CampaignController extends \BaseController {

  /**
   * Display a listing of the resource.
   * GET users/campaigns
   *
   * @return Response
  */
  public function index()
  {   
    $user = '';
    $drupal_uid = Input::has('drupal_uid') ? (int) Input::get('drupal_uid') : false;
    $id = Input::has('_id') ? Input::get('_id') : false;
    $mobile = Input::has('mobile') ? Input::get('mobile') : false;
    $email = Input::has('email') ? Input::get('email') : false;

    if($drupal_uid) {
      $user = User::where('drupal_uid', $drupal_uid)->first();
    }
    elseif($id) {
      $user = User::where('_id', $id)->first();
    }
    elseif($mobile) {
      $user = User::where('mobile', $mobile)->first();
    }
    elseif($email) {
      $user = User::where('email', $email)->first();
    }

    if($user instanceof User) {
      $campaigns = $user->campaigns;
      return Response::json($campaigns, 200);
    }

    return Response::json('The resource does not exist', 404);
  }


  /**
   * Store a newly created campaign signup in storage.
   * POST /campaigns/:nid/signup
   *
   * @return Response
  */
  public function signup($id)
  {
    $sid = Input::get('sid');
    $nid = (int) $id;
    if($nid) {
      if($sid) {
        $token = Request::header('Session');
        $user = Token::userFor($token);
        $campaign = $user->campaigns()->where('nid', '=', $nid)->first();

        if($campaign instanceof Campaign) {
          return Response::json("Campaign already exists", 401);
        }

        $campaign = new Campaign;
        $campaign->nid = $nid;
        $campaign->sid = $sid;
        $campaign = $user->campaigns()->save($campaign);
        $response = array(
          'created_at' => $campaign->created_at->format('Y-m-d H:i:s'),
          'sid' => $campaign->sid
        );
        return Response::json($response, 201);
      }
      return Response::json("Campaign SID not provided", 401);
    }
    else {
      return Response::json("Campaign node ID not provided", 401);
    }
  }


  /**
   * Store a newly created campaign report back in storage.
   * POST /campaigns/:nid/reportback
   *
   * @return Response
  */
  public function reportback($id)
  {
    $rbid = Input::get('rbid');
    $nid = (int) $id;
    if($nid) {
      if($rbid) {
        $token = Request::header('Session');
        $user = Token::userFor($token);
        $campaign = $user->campaigns()->where('nid', '=', $nid)->first();

        if(!($campaign instanceof Campaign)) {
          $campaign = new Campaign;
          $campaign->nid = $nid;
          $campaign->rbid = $rbid;
          $campaign->quantity = (int) Input::get('quantity');
          $campaign->why_participated = Input::get('why_participated');
          $campaign->file_url = Input::get('file_url');
          $campaign = $user->campaigns()->save($campaign);
        }
        else {
          $campaign->rbid = $rbid;
          $campaign->quantity = (int) Input::get('quantity');
          $campaign->why_participated = Input::get('why_participated');
          $campaign->file_url = Input::get('file_url');
          $campaign = $user->campaigns()->save($campaign);    
        }

        $response = array(
          'created_at' => $campaign->created_at->format('Y-m-d H:i:s'),
          'rbid' => $campaign->rbid
        );
        return Response::json($response, 201);
      }
      return Response::json("Campaign RBID not provided", 401);
    }
    else {
      return Response::json("Campaign node ID not provided", 401);
    }
  }

  /**
   * Update a campaign report back in storage.
   * PUT /campaigns/:nid/reportback
   *
   * @return Response
  */
  public function updateReportback($id)
  {
    $rbid = Input::get('rbid');
    $nid = (int) $id;
    if($nid) {
      if($rbid) {
        $token = Request::header('Session');
        $user = Token::userFor($token);
        $campaign = $user->campaigns()->where('rbid', '=', $rbid)->first();

        if(!($campaign instanceof Campaign)) {
          return Response::json("Campaign does not exist", 401);
        }

        $campaign->quantity = Input::get('quantity');
        $campaign->why_participated = Input::get('why_participated');
        $campaign->file_url = Input::get('file_url');
        $campaign = $user->campaigns()->save($campaign);

        $response = array(
          'created_at' => $campaign->created_at->format('Y-m-d H:i:s'),
          'rbid' => $campaign->rbid
        );
        return Response::json($response, 201);
      }
      return Response::json("Campaign RBID not provided", 401);
    }
    else {
      return Response::json("Campaign node ID not provided", 401);
    }
  }

}

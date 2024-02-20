<?php

namespace App\Http\Controllers;

use App\Models\CommentsUsersProfile;
use App\Models\CommentUserPost;
use App\Models\followers;
use App\Models\gallery_users;
use App\Models\LikesUsersProfile;
use App\Models\LikeUserPost;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccueilController extends Controller
{
    //
    public function index()
    {
        $id = Auth::user()->id;
        // Récupérons la dernière image de profil de l'utilisateur
        $getLastImgProfil = gallery_users::where("user_id", $id)->orderBy("created_at", "desc")->whereNotNull("file_profile")->first();

        // Récupérons toutes les dernières images de profil de chaque utilisateur
        $allFilesProfils = DB::table("gallery_users")->select("gallery_users.file_profile", "gallery_users.id", "gallery_users.user_id", "gallery_users.created_at", "users.name", "users.id as idUser")
            ->join("users", "users.id", "=", "gallery_users.user_id")
            ->orderBy("gallery_users.created_at", "desc")
            ->whereNotNull("gallery_users.file_profile")->get()->toArray();

        if (count($allFilesProfils) > 0) {
            for ($i = 0; $i < count($allFilesProfils); $i++) {

                // Récupérons le nombre de likes qu'à cette image
                $countLike = LikesUsersProfile::where("id_gallery", $allFilesProfils[$i]->id)->count("id_gallery");

                // Récupérons le nombre de commentaires qu'à cette image
                $countComment = CommentsUsersProfile::where("id_gallery", $allFilesProfils[$i]->id)->count("id_gallery");

                $allFilesProfils[$i]->likes = $countLike;
                $allFilesProfils[$i]->comments = $countComment;

                // Vérifions si l'utilisateur connecté n'a pas aimé cette photo
                $identifiant = Auth::user()->id;
                $verif = LikesUsersProfile::where("user_id", $identifiant)->where("id_gallery", $allFilesProfils[$i]->id)->first();
                $trueVariable = false;
                if ($verif !== null) {
                    $trueVariable = true;
                }
                $allFilesProfils[$i]->trueVariable = $trueVariable;
            }
        }

        $merges = $allFilesProfils;

        // Récupérons toutes les publications faites par les utilisateurs
        $posts = DB::table('posts as p')
            ->select(
                'u_creator.name as creator_name',
                'p.id',
                'p.uuid',
                'p.body',
                'p.bgc',
                'p.image',
                'p.video',
                'p.created_at',
                DB::raw('(SELECT GROUP_CONCAT(CONCAT(u_tagged.id, "-", u_tagged.name)) FROM tags_users tu INNER JOIN users u_tagged ON tu.user_id = u_tagged.id WHERE tu.uuid = p.uuid) as tagged_names'),
                'p.user_id'
            )
            ->leftJoin('users as u_creator', 'p.user_id', '=', 'u_creator.id')
            ->orderBy('p.created_at', 'desc')
            ->get();

        if (count($posts) > 0) {
            foreach ($posts as $key => $post) {
                $lastImg = gallery_users::select("gallery_users.file_profile", "gallery_users.id", "gallery_users.user_id", "gallery_users.created_at")
                    ->where("user_id", $post->user_id)->orderBy("created_at", "desc")->whereNotNull("gallery_users.file_profile")->first();
                $post->image_user = $lastImg !== null ? $lastImg->file_profile : null;

                // Récupérons le nombre de likes qu'à cette publication
                $countLike = LikeUserPost::where("id_post", $post->id)->count("id_post");

                // Récupérons le nombre de commentaires qu'à cette publication
                $countComment = CommentUserPost::where("id_post", $post->id)->count("id_post");

                $post->likes = $countLike;
                $post->comments = $countComment;

                $identifiant = Auth::user()->id;
                // Vérifions si l'utilisateur connecté n'a pas aimé cette photo
                $verif = LikeUserPost::where("user_id", $identifiant)->where("id_post", $post->id)->first();
                $variableTwo = false;
                if ($verif !== null) {
                    $variableTwo = true;
                }
                $post->trueVariable = $variableTwo;
            }
            // On met les deux tableaux ensembles
            $merges = array_merge($allFilesProfils, $posts->toArray());

            // Tri du tableau fusionné selon la date de création
            usort($merges, function ($a, $b) {
                // return strtotime($a->created_at) - strtotime($b->created_at);
                return strtotime($b->created_at) - strtotime($a->created_at);
            });
        }

        // Récupérons tous ceux à qui l'utilisateur est abonné
        $getFollowing = followers::where("user_id_connect", $id)->get()->toArray();
        // Récupération de tous les id des utilisateurs
        $identifiants = [];

        if (count($getFollowing) === 0) {
            array_push($identifiants, $id);
        } else {

            foreach ($getFollowing as $key => $val) {
                array_push($identifiants, $val["user_id"]);
            }
    
            array_push($identifiants, $id);

        }
        $tab1 = [];
        $follow = User::whereNotIn("id", $identifiants)->get()->toArray();
        for ($i = 0; $i < count($follow); $i++) {
            // Récupérons la dernière image de profil de l'utilisateur
            $getLast = gallery_users::where("user_id", intval($follow[$i]["id"]))->orderBy("created_at", "desc")->whereNotNull("file_profile")->first();
            if ($getLast !== null) {
                $tab1[$i] = $follow[$i];
                $tab1[$i]["image"] = $getLast->file_profile;
            } else {
                $tab1[$i] = $follow[$i];
                $tab1[$i]["image"] = null;
            }
        }

        $follow = $tab1;
        
        $tableau["follow"] = $follow;
        
        if($getLastImgProfil !== null)
        {
            $img = $getLastImgProfil->file_profile;
        } else {
            $getLastImgProfil = [];
            $img = null;
        }
        $tableau["follow"] = $follow;
        $tableau["img"] = $img;
        $tableau["getLastImgProfil"] = $getLastImgProfil;
        $tableau["mergesTab"] = $merges;

        return Inertia::render('Accueil', $tableau);
    }
}

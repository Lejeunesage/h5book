<?php

namespace App\Http\Controllers;

use App\Models\CommentsUsersProfile;
use App\Models\CommentUserPost;
use App\Models\followers;
use App\Models\gallery_users;
use App\Models\LikesUsersProfile;
use App\Models\LikeUserPost;
use App\Models\Statut;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccueilController extends Controller
{

    // Fonction pour supprimer une seule image
    // KolaDev
    public function imgStatut(Request $request)
    {
        if (isset($request->tableau) && count($request->tableau) > 0) {
            try {
                if (isset($request->tableau["image"])) {
                    unlink(base_path() . "/storage/app/public/statut/" . $request->tableau["image"]);
                } else {
                    unlink(base_path() . "/storage/app/public/statut/" . $request->tableau["video"]);
                }
            } catch (\Throwable $th) {
                return json_encode(["error" => "Une erreur est survenue lors de la suppression !"]);
            }
        }
        return json_encode(["success" => "Suppression réussie"]);
    }

    // Fonction pour supprimer toutes les images
    // KolaDev

    public function allImgSta(Request $request)
    {
        if (isset($request->statusImg) && count($request->statusImg) > 0) {
            foreach ($request->statusImg as $key => $value) {
                try {
                    if (isset($value["image"])) {
                        unlink(base_path() . "/storage/app/public/statut/" . $value["image"]);
                    } else {
                        unlink(base_path() . "/storage/app/public/statut/" . $value["video"]);
                    }
                } catch (\Throwable $th) {
                    return json_encode(["error" => "Une erreur est survenue lors de la suppression !"]);
                }
            }
        }
        return json_encode(["success" => "Suppression réussie"]);
    }

    // Fonction pour charger les images/vidéos des status
    // KolaDev
    public function statutImag(Request $request)
    {
        $allNames = $_FILES["myStatut"]["name"];
        $allTab = [];
        for ($i = 0; $i < count($allNames); $i++) {
            $name = $_FILES["myStatut"]["name"][$i];
            $tmp_name = $_FILES["myStatut"]["tmp_name"][$i];
            $size = $_FILES["myStatut"]["size"][$i];
            $error = $_FILES["myStatut"]["error"][$i];
            // Taille maximale qu'on accepte (15Mo)
            $maximal = 15000000;

            // Les extensions d'image/de vidéo qu'on accepte
            $tableauExtension = ["jpg", "jpeg", "png", "mp4", "webm"];

            // Récupération de l'extension de l'image/la vidéo sélectionnée par l'utilisateur
            $extensionImage = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            // Vérifions si l'extension de l'image/la vidéo se trouve dans notre tableau d'extensions
            if (in_array($extensionImage, $tableauExtension)) {
                if ($size <= $maximal) {
                    if ($error == 0) {
                        $newName = uniqid("statut-", true);
                        $file = $newName . "." . $extensionImage;
                        $location = base_path() . "/storage/app/public/statut/" . $file;
                        move_uploaded_file($tmp_name, $location);
                        if (in_array($extensionImage, ["mp4", "webm"])) {
                            array_push($allTab, ["video" => $file, "contenu" => ""]);
                        } else {
                            array_push($allTab, ["image" => $file, "contenu" => ""]);
                        }

                    } else {
                        // return json_encode(["error" => "Le fichier ne peut être prise en charge !!!"]);
                    }
                } else {
                    // return json_encode(["error" => "La taille de ce fichier dépasse la taille maximale que nous validons (15Mo) !!!"]);
                }
            } else {
                // return json_encode(["error" => "L'extension de ce fichier ne figure pas dans la liste d'extension que nous acceptons !!!"]);
            }
        }
        return json_encode(["success" => $allTab]);
    }

    //
    public function index()
    {
        $id = Auth::user()->id;
        // Récupérons la dernière image de profil de l'utilisateur
        $getLastImgProfil = gallery_users::where("user_id", $id)->orderBy("created_at", "desc")->whereNotNull("file_profile")->first();

        // Récupérons toutes les dernières images de profil de chaque utilisateur
        $allFilesProfils = DB::table("gallery_users")->select(
            "gallery_users.file_profile",
            "gallery_users.id",
            "gallery_users.user_id",
            "gallery_users.created_at",
            "users.name",
            "users.id as idUser",
            DB::raw("TIMESTAMPDIFF(SECOND, gallery_users.created_at, NOW()) as diff_in_seconds"),
            DB::raw("TIMESTAMPDIFF(MINUTE, gallery_users.created_at, NOW()) as diff_in_minutes"),
            DB::raw("TIMESTAMPDIFF(HOUR, gallery_users.created_at, NOW()) as diff_in_hours"),
            DB::raw("TIMESTAMPDIFF(DAY, gallery_users.created_at, NOW()) as diff_in_days"),
            DB::raw("TIMESTAMPDIFF(WEEK, gallery_users.created_at, NOW()) as diff_in_weeks"),
            DB::raw("TIMESTAMPDIFF(MONTH, gallery_users.created_at, NOW()) as diff_in_months"),
            DB::raw("TIMESTAMPDIFF(YEAR, gallery_users.created_at, NOW()) as diff_in_years")
        )
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
                'p.user_id',
                DB::raw("TIMESTAMPDIFF(SECOND, p.created_at, NOW()) as diff_in_seconds"),
                DB::raw("TIMESTAMPDIFF(MINUTE, p.created_at, NOW()) as diff_in_minutes"),
                DB::raw("TIMESTAMPDIFF(HOUR, p.created_at, NOW()) as diff_in_hours"),
                DB::raw("TIMESTAMPDIFF(DAY, p.created_at, NOW()) as diff_in_days"),
                DB::raw("TIMESTAMPDIFF(WEEK, p.created_at, NOW()) as diff_in_weeks"),
                DB::raw("TIMESTAMPDIFF(MONTH, p.created_at, NOW()) as diff_in_months"),
                DB::raw("TIMESTAMPDIFF(YEAR, p.created_at, NOW()) as diff_in_years")
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

        // Récupérons les statuts des personnes que l'utilisateur suit
        $status = Statut::select("statuts.uuid", "statuts.user_id", "statuts.id", "statuts.body", "statuts.image", "statuts.video", "statuts.bgc", "users.id As idUser")
            ->join("users", "users.id", "=", "statuts.user_id")
            ->whereIn("statuts.user_id", $identifiants)
            ->get()
            ->toArray();
        $tableauStatut = [];
        for ($i = 0; $i < count($identifiants); $i++) {
            $statut = Statut::select("statuts.uuid", "statuts.user_id", "statuts.id", "statuts.body", "statuts.image", "statuts.video", "statuts.bgc", "users.id As idUser", "users.name")
                ->join("users", "users.id", "=", "statuts.user_id")
                ->where("statuts.user_id", $identifiants[$i])
                ->get()
                ->toArray();
            if(count($statut) > 0)
            {
                // Récupérons la dernière image de profil de l'utilisateur
                $getLast = gallery_users::where("user_id", intval($identifiants[$i]))->orderBy("created_at", "desc")->whereNotNull("file_profile")->first();
                if ($getLast !== null) {
                    $tableauStatut[$i] = $statut;
                    $tableauStatut[$i]["image_profil"] = $getLast->file_profile;
                } else {
                    $tableauStatut[$i] = $statut;
                    $tableauStatut[$i]["image_profil"] = null;
                }
            }
        }
        // for ($i = 0; $i < count($status); $i++) {
        //     // Récupérons la dernière image de profil de l'utilisateur
        //     $getLast = gallery_users::where("user_id", intval($status[$i]["idUser"]))->orderBy("created_at", "desc")->whereNotNull("file_profile")->first();
        //     if ($getLast !== null) {
        //         $tableauStatut[$i] = $status[$i];
        //         $tableauStatut[$i]["image_profil"] = $getLast->file_profile;
        //     } else {
        //         $tableauStatut[$i] = $status[$i];
        //         $tableauStatut[$i]["image_profil"] = null;
        //     }
        // }
        $status = $tableauStatut;

        $follow = $tab1;

        $tableau["follow"] = $follow;

        if ($getLastImgProfil !== null) {
            $img = $getLastImgProfil->file_profile;
        } else {
            $getLastImgProfil = [];
            $img = null;
        }

        $tableau["status"] = $status;
        $tableau["img"] = $img;
        $tableau["getLastImgProfil"] = $getLastImgProfil;
        $tableau["mergesTab"] = $merges;

        return Inertia::render('Accueil', $tableau);
    }
}

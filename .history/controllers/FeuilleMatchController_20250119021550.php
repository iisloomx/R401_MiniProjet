<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/FeuilleMatch.php';
require_once '../models/Match.php'; // Inclure le modèle Match
require_once '../models/Joueur.php'; // Inclure le modèle Joueur
require_once '../models/Commentaire.php';
require_once '../models/Participer.php';
$database = new Database();
$db = $database->getConnection();
$feuilleMatch = new FeuilleMatch($db);

$action = $_GET['action'] ?? 'afficher';

switch ($action) {

    case 'afficher':
        $id_match = $_GET['id_match'] ?? null;
        if (!$id_match) {
            echo "ID du match non spécifié.";
            exit;
        }
        
        $gameMatch = new GameMatch($db);
        $match = $gameMatch->obtenirMatch($id_match);
    
        $titulaires = $feuilleMatch->obtenirTitulairesParMatch($id_match);
        $remplacants = $feuilleMatch->obtenirRemplacantsParMatch($id_match);
        
        require '../views/feuilles_matchs/index.php';
        break;
    
        
        $gameMatch = new GameMatch($db);
        $match = $gameMatch->obtenirMatch($id_match);
        $participe = $feuilleMatch->obtenirJoueursParMatch($id_match);
        
        require '../views/feuilles_matchs/index.php';
        break;

        case 'ajouter':
            $id_match = $_GET['id_match'] ?? null;
        
            if (!$id_match) {
                echo "ID du match non spécifié.";
                exit;
            }
        
            $gameMatch = new GameMatch($db);
            $match = $gameMatch->obtenirMatch($id_match);
        
            // Obtenir les joueurs non sélectionnés
            $joueursNonSelectionnes = $feuilleMatch->obtenirJoueursNonSelectionnes($id_match);
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'numero_licence' => $_POST['numero_licence'],
                    'id_match' => $_POST['id_match'],
                    'role' => $_POST['role'],
                    'poste' => $_POST['poste']
                ];
        
                try {
                    $feuilleMatch->ajouterJoueur($data);
                    header("Location: FeuilleMatchController.php?action=afficher&id_match=" . $_POST['id_match']);
                    exit();
                } catch (Exception $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }
        
            require '../views/feuilles_matchs/ajouter.php';
            break;
        
               

            case 'evaluer':
                $id_match = $_GET['id_match'] ?? null;
            
                if (!$id_match) {
                    echo "ID du match non spécifié.";
                    exit;
                }
            
                // Fetch players associated with the match
                $participe = $feuilleMatch->obtenirJoueursParMatch($id_match);
            
                // Pass `id_match` and `participe` to the view
                require '../views/feuilles_matchs/evaluer.php';
                break;
            
            
                case 'valider_evaluation':
                    $id_match = $_GET['id_match'] ?? null;
                
                    if (!$id_match) {
                        echo "<script>alert('ID du match non spécifié.'); window.location.href='FeuilleMatchController.php?action=evaluer&id_match={$id_match}';</script>";
                        exit;
                    }
                
                    // Récupérer les évaluations soumises
                    $evaluations = $_POST['evaluations'] ?? [];
                
                    if (empty($evaluations)) {
                        echo "<script>alert('Aucune évaluation soumise.'); window.location.href='FeuilleMatchController.php?action=evaluer&id_match={$id_match}';</script>";
                        exit;
                    }
                
                    try {
                        foreach ($evaluations as $id => $evaluation) {
                            // Validation de l'évaluation (entre 1 et 5)
                            if (!is_numeric($evaluation) || $evaluation < 1 || $evaluation > 5) {
                                echo "<script>alert('Les évaluations doivent être des nombres entre 1 et 5.'); window.location.href='FeuilleMatchController.php?action=evaluer&id_match={$id_match}';</script>";
                                exit;
                            }
                
                            // Appeler la fonction evaluerJoueur pour chaque joueur
                            $feuilleMatch->evaluerJoueur([
                                'id' => $id,
                                'evaluation' => $evaluation,
                                'id_match' => $id_match
                            ]);
                        }
                
                        // Si tout est validé, message de succès et redirection
                        echo "<script>alert('Évaluations enregistrées avec succès.'); window.location.href='FeuilleMatchController.php?action=afficher&id_match={$id_match}';</script>";
                        exit;
                    } catch (Exception $e) {
                        // Gestion des erreurs
                        echo "<script>alert('Erreur lors de l\'enregistrement des évaluations : " . $e->getMessage() . "'); window.location.href='FeuilleMatchController.php?action=evaluer&id_match={$id_match}';</script>";
                        exit;
                    }
                
                

        case 'modifier':
            $id_match = $_GET['id_match'] ?? null;
        
            if (!$id_match) {
                echo "ID du match non spécifié.";
                exit;
            }
        
            // Récupérer les joueurs actuels (titulaires et remplaçants)
            $titulaires = $feuilleMatch->obtenirTitulairesParMatch($id_match) ?? [];
            $remplacants = $feuilleMatch->obtenirRemplacantsParMatch($id_match) ?? [];
        
            // Charger la vue de modification
            require '../views/feuilles_matchs/modifier.php';
            break;
        
            case 'valider_modification':
                $id_match = $_POST['id_match'] ?? null;
            
                if (!$id_match) {
                    $_SESSION['error'] = "ID du match manquant.";
                    header("Location: FeuilleMatchController.php?action=modifier&id_match={$id_match}");
                    exit;
                }
            
                $selections = $_POST['joueur_selectionnes'] ?? [];
            
                // Vérifier si aucune sélection n'a été faite
                if (empty($selections)) {
                    $_SESSION['error'] = "Aucun joueur sélectionné pour ce match.";
                    header("Location: FeuilleMatchController.php?action=modifier&id_match={$id_match}");
                    exit;
                }
            
                try {
                    foreach ($selections as $selection) {
                        if (!empty($selection['numero_licence']) && !empty($selection['role']) && !empty($selection['poste'])) {
                            $feuilleMatch->modifierSelection([
                                'numero_licence' => $selection['numero_licence'],
                                'id_match' => $id_match,
                                'role' => $selection['role'],
                                'poste' => $selection['poste']
                            ]);
                        }
                    }
            
                    $_SESSION['success'] = "Modifications enregistrées avec succès.";
                    header("Location: FeuilleMatchController.php?action=afficher&id_match={$id_match}");
                    exit;
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: FeuilleMatchController.php?action=modifier&id_match={$id_match}");
                    exit;
                }
            
        
                 

            case 'supprimer':
                $id_match = $_GET['id_match'] ?? null;
            
                if (!$id_match) {
                    $_SESSION['error'] = "ID du match non spécifié.";
                    header("Location: FeuilleMatchController.php?action=afficher");
                    exit();
                }
            
                // Fetch players
                $titulaires = $feuilleMatch->obtenirTitulairesParMatch($id_match) ?? [];
                $remplacants = $feuilleMatch->obtenirRemplacantsParMatch($id_match) ?? [];
            
                // Load suppression view
                require '../views/feuilles_matchs/supprimer.php';
                break;
            
                case 'valider_suppression':
                    $id_match = $_GET['id_match'] ?? null;
                
                    if (!$id_match) {
                        $_SESSION['error'] = "ID du match non spécifié.";
                        header("Location: FeuilleMatchController.php?action=afficher");
                        exit;
                    }
                
                    $joueursASupprimer = $_POST['joueur_a_supprimer'] ?? [];
                
                    // Vérifier si aucune sélection n'a été faite
                    if (empty($joueursASupprimer)) {
                        $_SESSION['error'] = "Aucun joueur sélectionné pour suppression.";
                        header("Location: FeuilleMatchController.php?action=supprimer&id_match={$id_match}");
                        exit;
                    }
                
                    try {
                        foreach ($joueursASupprimer as $joueur) {
                            $numeroLicence = $joueur['numero_licence'];
                            $feuilleMatch->supprimerJoueurParLicenceEtMatch($numeroLicence, $id_match);
                        }
                
                        $_SESSION['success'] = "Les joueurs sélectionnés ont été supprimés avec succès.";
                        header("Location: FeuilleMatchController.php?action=afficher&id_match={$id_match}");
                        exit;
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
                        header("Location: FeuilleMatchController.php?action=supprimer&id_match={$id_match}");
                        exit;
                    }
                
                
                    case 'valider_selection':
                        $id_match = $_GET['id_match'] ?? null;
                    
                        if (!$id_match) {
                            echo "<script>alert('ID du match non spécifié.'); window.location.href='FeuilleMatchController.php?action=selectionner&id_match={$id_match}';</script>";
                            exit;
                        }
                    
                        $selections = $_POST['joueur_selectionnes'] ?? [];
                    
                        $titularCount = 0;
                        $joueursValides = array_filter($selections, function ($selection) use (&$titularCount) {
                            if (!empty($selection['numero_licence']) && !empty($selection['role']) && !empty($selection['poste'])) {
                                if ($selection['role'] === 'Titulaire') {
                                    $titularCount++;
                                }
                                return true;
                            }
                            return false;
                        });
                    
                        if ($titularCount < 11) {
                            echo "<script>alert('Vous devez sélectionner au moins 11 titulaires.'); window.location.href='FeuilleMatchController.php?action=selectionner&id_match={$id_match}';</script>";
                            exit;
                        }
                    
                        require_once '../models/Participer.php';
                        $participerModel = new Participer($db);
                    
                        try {
                            foreach ($joueursValides as $selection) {
                                $data = [
                                    'numero_licence' => $selection['numero_licence'],
                                    'id_match' => $id_match,
                                    'role' => $selection['role'],
                                    'poste' => $selection['poste'],
                                    'evaluation' => null
                                ];
                                $participerModel->ajouterSelection($data);
                            }
                    
                            echo "<script>alert('Sélection validée avec succès.'); window.location.href='FeuilleMatchController.php?action=afficher&id_match={$id_match}';</script>";
                            exit;
                        } catch (Exception $e) {
                            echo "<script>alert('Erreur : {$e->getMessage()}'); window.location.href='FeuilleMatchController.php?action=selectionner&id_match={$id_match}';</script>";
                            exit;
                        }
                    

        
    case 'valider_modification':
        $id_match = $_GET['id_match'] ?? null;
    
        if (!$id_match) {
            echo "ID du match non spécifié.";
            exit;
        }
    
        $selections = $_POST['joueur_selectionnes'] ?? [];
    
        // Compter le nombre de titulaires
        $titularCount = 0;
        foreach ($selections as $selection) {
            if ($selection['role'] === 'Titulaire') {
                $titularCount++;
            }
        }
    
        // Vérifier qu'il y a au moins 11 titulaires
        if ($titularCount < 11) {
            $_SESSION['error'] = "Vous devez sélectionner au moins 11 titulaires pour valider la sélection.";
            header("Location: FeuilleMatchController.php?action=modifier&id_match={$id_match}");
            exit;
        }
    
        // Appliquer les modifications si la validation est réussie
        try {
            foreach ($selections as $selection) {
                $data = [
                    'numero_licence' => $selection['numero_licence'],
                    'id_match' => $id_match,
                    'role' => $selection['role'],
                    'poste' => $selection['poste']
                ];
                $feuilleMatch->modifierSelection($data);
            }
            $_SESSION['success'] = "La sélection a été modifiée avec succès.";
            header("Location: FeuilleMatchController.php?action=afficher&id_match={$id_match}");
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la modification : " . $e->getMessage();
            header("Location: FeuilleMatchController.php?action=modifier&id_match={$id_match}");
            exit;
        }
        break;


        case 'valider_feuille':
            $id_match = $_GET['id_match'] ?? null;
        
            if (!$id_match) {
                $_SESSION['error'] = "ID du match non spécifié.";
                header("Location: FeuilleMatchController.php?action=afficher");
                exit;
            }
        
            // Vérifier le nombre de titulaires
            $titulaires = $feuilleMatch->obtenirTitulairesParMatch($id_match);
        
            if (count($titulaires) < 11) {
                $_SESSION['error'] = "La feuille de match ne peut pas être validée : moins de 11 titulaires.";
                header("Location: FeuilleMatchController.php?action=afficher&id_match={$id_match}");
                exit;
            }
        
            // Mettre à jour l'état de la feuille de match
            $result = $feuilleMatch->mettreAJourEtatMatch($id_match, 'Validé');
        
            if ($result) {
                $_SESSION['success'] = "La feuille de match a été validée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la validation de la feuille de match.";
            }
        
            header("Location: FeuilleMatchController.php?action=afficher&id_match={$id_match}");
            exit;
            break;
        
        
    
    default:
        echo "Action non reconnue.";
        break;
}


?>

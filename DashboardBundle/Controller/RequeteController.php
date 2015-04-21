<?php

namespace Berd\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Berd\DashboardBundle\Entity\Requete;
use Berd\DashboardBundle\Form\RequeteType;

/**
 * Requete controller.
 *
 * @Route("/requete")
 */
class RequeteController extends Controller
{
	$operateur = "";
	$listeParams = "";
	$key = 0; $operator = 0; $value = 0;
	$resultat = "";
	$tabCorpRequete = "";
	$tabParamsRequete = "";
	$corpRequete = "";
	$nbMotClee = 0;
	$dernierFois = false;
	
	/**
	* Cette fonction permet d'extraire d'une requête le corp de la requête et ses paramêtres.
	* TODO cette fonction fonctionnent seulement si la synthaxe DQL est bien respecter,
	* les deux points annonçant un paramètre devant être coller à ce dernier.
	* @param requete correspond à une requête DQL de type String.
	**/
	function dissocierRequete($requete){
		global $nbMotClee, $key, $operator, $value, $resultat, $listeParams, $corpRequete, $dernierFois, $tabCorpRequete, $tabParamsRequete;
		$nbParams = 0;
		$nbMotClee = compterMotClee($requete);
		echo " le nombre totale de mot clee est de :: $nbMotClee<br><br>";
		if($nbMotClee == 0){
		 echo "$requete";
		 
		}else if($nbMotClee == 1){
			$posWhere = rechercherLeMot($requete, 'WHERE');
			
			$finPosWhere = $posWhere + 5;
			$resultat = separerRequete($requete, 0, $finPosWhere);
		    
			$siRecuperer = recupererKOV($resultat[1]);
			$corpRequete = recomposerRequete($resultat);
			
		}else{
			$resultat = chercherMotClee($requete);
			$tabCorpRequete[0] = $resultat[0];
			
			for($cpt = 0; $cpt < ($nbMotClee - 1); $cpt++){
				
				$requeteSuivante = $resultat[1];
				$resultat = chercherMotClee($requeteSuivante);
				$siRecuperer = recupererKOV($resultat[0]);
			
				$tabCorpRequete[$cpt+1] = $resultat[0];
				$tailleListeParams = sizeof($listeParams);
				
				if($siRecuperer){
					if($tailleListeParams > 1){
						$tabParamsRequete[$nbParams] = $listeParams;
						$nbParams++;
					}
					$key++; $operator++; $value++;
				}
			}
			
			$dernierFois = true;
			recupererKOV($resultat[1]);
			$tabCorpRequete[$cpt+1] = $resultat[1];
			$tabParamsRequete[$nbParams] = $listeParams;
			$corpRequete = recomposerRequete($tabCorpRequete);
		}
	}
	
	/**
	* Cette fonction recupère la clée, l'opérateur et la valeur qui forme ensemble un paramètre.
	* @param tableauResultat correspond au tableau qu'ont souhaite vérifier si il y a un paramètre à récuperer.
	* @return siTrouver retourne vrais si un paramètre est trouver sinon retourne faux.
	*/
	function recupererKOV($tableauResultat){
		global $operateur, $listeParams, $key, $operator, $value, $resultat, $nbMotClee, $dernierFois;
		$siTrouver = false;
		
		$siOperateurTrouver = chercherOperateur($tableauResultat);
		
		if($siOperateurTrouver){
			$result = decomposerRequete(" ", $tableauResultat);
			$tailleResult = sizeof($result);
			
			for($cpt = 0; $cpt < $tailleResult; $cpt++){
			    $motRechercher = $result[$cpt];
				if(chercherOpDansTableau($motRechercher)){
					$listeParams[0] = $result[$cpt - 1];
					$listeParams[1] = $result[$cpt];
					$listeParams[2] = $result[$cpt + 1];
					
					//jenregistre les nouvelles valeurs dans le result
					$result[$cpt - 1] = " key".$key." ";
					$result[$cpt] = " operator".$operator." ";
					$result[$cpt + 1] = " value".$value." ";
					
					//je recompose la requete decomposer
					if($nbMotClee == 1 or $dernierFois == true){
						$resultat[1] = recomposerRequete($result);
					}else{
						$resultat[0] = recomposerRequete($result);
					}
					
					break;
				}
			}
			$siTrouver = true;
		}
		
		return $siTrouver;
	}
	
	/**
	* Comptent le nombre de mot clée que la requête possède.
	* @param requete la requête qu'on souhaite vérifier le nombre de mot clée.
	* @return le nombre de mot clee en tout retrouver
	*/
	function compterMotClee($requete){
		$listeMotClee = ['WHERE', 'WITH', 'AND', 'JOIN'];
		$longueurListe = sizeof($listeMotClee);
		$nbTrouver = 0;
		
		for($cpt = 0; $cpt < $longueurListe; $cpt++){
			$nbTrouver = $nbTrouver + substr_count($requete, $listeMotClee[$cpt] );
		}

		return $nbTrouver;
	}
	
	/**
	* Cherche un opérateur dans un tableau.
	* @param tableau dans lequels ont effecturera la recherche.
	* @return operateurTrouver retourne vraie si un opérateur est trouver sinon retourne faux.
	*/
	function chercherOperateur($tableau){
		global $operateur;
		$listeOperateur = ['=', '!=', '==', '===', '>=', '<=', '>', '<'];
		$longueurListe = sizeof($listeOperateur);
		$operateurTrouver = false;
		
		for($cpt = 0; $cpt < $longueurListe; $cpt++){
			$trouver = rechercherLeMot($tableau, $listeOperateur[$cpt]);
			if($trouver != 0){
				$operateur = $listeOperateur[$cpt];
				$operateurTrouver = true;
				break;	
			}
		}
		
		return $operateurTrouver;
	}
	
	/**
	* Idem que chercherOperateur, Cherche un opérateur dans un tableau.
	* @param tableau dans lequels ont effecturera la recherche.
	* @return operateurTrouver retourne vraie si un opérateur est trouver sinon retourne faux.
	*/
	function chercherOpDansTableau($tableau){
		global $operateur;
		$listeOperateur = ['=', '!=', '==', '===', '>=', '<=', '>', '<'];
		$longueurListe = sizeof($listeOperateur);
		$operateurTrouver = false;
		
		for($cpt = 0; $cpt < $longueurListe; $cpt++){
			if(stristr($tableau, $listeOperateur[$cpt]) == TRUE) {
				$operateurTrouver = true;	
			}
		}
		return $operateurTrouver;
	}
	
	/**
	* Recherche un motClee dans une requête.
	* @param requete la requête qui servira de recherche.
	* @return resultat retourne un tableau contenant la requête séparer en deux parties.
	*/
	function chercherMotClee($requete){
		$listeMotClee = ['WHERE', 'WITH', 'AND', 'JOIN'];
		$listeVariable = [$posWhere = 0, $posWith = 0, $posAnd = 0, $posJoin = 0];
		$longueurListe = sizeof($listeMotClee);
		
		
		for($cpt = 0; $cpt < $longueurListe; $cpt++){
			$listeVariable[$cpt] = rechercherLeMot($requete, $listeMotClee[$cpt]);
		}
		
		for($cpt = 0; $cpt < $longueurListe; $cpt++){
			if($listeVariable[$cpt] == null){
				$listeVariable[$cpt] = 0;
			}
		}
		
		$posElement = 0;
		asort($listeVariable);
		foreach ($listeVariable as $key => $val) {
		   if($val != 0){
			$premierElement = $listeVariable[$key];
			$posElement = $key;
			break;
		   } 
        }

		$longueurMot = strlen($listeMotClee[$posElement]);
		$finPos = $premierElement + $longueurMot;
		$resultat = separerRequete($requete, 0, $finPos);
		
		return $resultat;
	}
	
	/**
	* recherche un mot dans une phrase et retourne un boolean.
	* @param myString le texte dans lequel ont va rechercher un mot en particulier
	* @param findMe le mot qu'on souhaite rechercher
	* @return siTrouver retourne vrais si une occurence est trouver sinon retourne faux
	*/
	function rechercherUnMot($myString, $findMe){
		$pos = strripos($myString, $findMe);
		
		if($pos == true){
			//echo "c trouver ($findMe) dans ($myString) a la position ($pos)";
			$siTrouver = true;
		}else{
			//echo "c pas trouver ($findMe) dans ($myString)";
			$siTrouver = false;
		}
		
		return $siTrouver;
	}
	
	/**
	* recherche un mot dans une phrase et retourne sa position.
	* @param myString le texte dans lequel ont va rechercher un mot en particulier
	* @param findMe le mot qu'on souhaite rechercher
	* @return trouverPos retourne la position de l'occurence trouver
	*/
	function rechercherLeMot($myString, $findMe){
		$pos = stripos($myString, $findMe);
		$trouverPos = 0;
		
		if($pos == true){
			//echo "c trouver ($findMe) dans ($myString) a la position ($pos)<br>";
			$trouverPos = $pos;
			
		}else{
			//echo "c pas trouver ($findMe) dans ($myString) a la position ($pos) <br>";
			$trouverPos = $pos;
		}
		
		return $trouverPos;
	}
	
	/**
	* Cette fonction sépare la requête en deux partis.
	* @param requete la requete à découper.
	* @param position la position ou on souhaite découper la requête.
	* @param longueur la longueur du texte qu'on souhaite découper.
	* @return $tabParti retourne un tableau contenant deux string.
	*/
	function separerRequete($requete, $position, $longueur){
		$premierParti = substr($requete, $position, $longueur);
		$secondParti = substr($requete, $longueur);
		
		return $tabParti = [$premierParti, $secondParti];
	}
	
	/**
	* Permet de décomposer un texte selon un séparateur spécifié en plusieurs morceaux stocker dans un tableau.
	* @param separateur détermine par rapport à quoi on souhaite découper le texte.
	* @param requete est le texte à découper 
	* @return resultat retourne un tableau contenant la requete découper
	*/
	function decomposerRequete($separateur, $requete){
		$resultat = "";
		
		$resultat = explode($separateur, $requete);
		
		return $resultat;  
	}
	
	/**
	* Recompose un texte avec des fragments de texte
	* @param requete de type tableau contient des morceaux de texte qu'on souhaite rassembler
	* @return resultat retourne un String d'un ensemble de texte recomposer.
	*/
	function recomposerRequete($requete){
		$resultat = "";
		
		$resultat = implode($requete);
		
		return $resultat;
	}
	
    /**
     * Lists all Requete entities.
     *
     * @Route("/", name="requete")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BerdDashboardBundle:Requete')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Requete entity.
     *
     * @Route("/", name="requete_create")
     * @Method("POST")
     * @Template("BerdDashboardBundle:Requete:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Requete();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('requete_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Requete entity.
     *
     * @param Requete $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Requete $entity)
    {
        $form = $this->createForm(new RequeteType(), $entity, array(
            'action' => $this->generateUrl('requete_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Requete entity.
     *
     * @Route("/new", name="requete_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Requete();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Requete entity.
     *
     * @Route("/{id}", name="requete_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requete entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Requete entity.
     *
     * @Route("/{id}/edit", name="requete_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requete entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Requete entity.
    *
    * @param Requete $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Requete $entity)
    {
        $form = $this->createForm(new RequeteType(), $entity, array(
            'action' => $this->generateUrl('requete_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Requete entity.
     *
     * @Route("/{id}", name="requete_update")
     * @Method("PUT")
     * @Template("BerdDashboardBundle:Requete:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requete entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('requete_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
	
	
    /**
     * Deletes a Requete entity.
     *
     * @Route("/{id}", name="requete_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Requete entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('requete'));
    }

    /**
     * Creates a form to delete a Requete entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('requete_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
	
}

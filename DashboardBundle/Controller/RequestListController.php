<?php

namespace Berd\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Berd\DashboardBundle\Entity\RequestList;
use Berd\DashboardBundle\Entity\Results;
use Berd\DashboardBundle\Entity\ResultFields;
use Berd\DashboardBundle\Entity\Requete;
use Berd\DashboardBundle\Form\RequestListType;
use \DateTime;

/**
 * RequestList controller.
 *
 * @Route("/requestlist")
 */
class RequestListController extends Controller
{
	/** 
	*  @Route("/afficherlist", name="requestlist_afficher")
	*  @Method("GET")
	*  @Template("BerdDashboardBundle:RequestList:requestlistplus.html.twig")
    */
	public function afficherListAction(){
		$em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BerdDashboardBundle:RequestList')->findAll();
		$entities2 = $em->getRepository('BerdDashboardBundle:Requete')->findAll();
		
		return array(
            'entities1' => $entities, 'entities2' => $entities2,
        );
	}
	
	/**
	*	récupère tout les requêtes liée à une requestList
	*
	*   @Route("/recupRequete", name="requestlist_recupRequete")
    *   @Template("BerdDashboardBundle:RequestList:recupRequete.html.twig")
	*/
	public function recupRequeteAction(){
		$requestListId = 3;
		
		$query = $this->getDoctrine()->getManager()
               ->createQuery('SELECT r.id, r.body, r.requestName  FROM Berd\DashboardBundle\Entity\Requete r
                        WHERE r.requestList = :requestListId')
		->setParameter('requestListId', $requestListId);

		try {
			$entity = $query->getResult();
		} catch (\Doctrine\Orm\NoResultException $e) {
			$entity = null;
		}
		
        return array('entity' => $entity, );
	}
	
	/**
	*	récupère tout les paramètres liée à une requete
	*
	*   @Route("/recupParams", name="requestlist_recupParams")
    *   @Template("BerdDashboardBundle:RequestList:recupParams.html.twig")
	*/
	public function recupParamsAction($requeteId){
		
		$query = $this->getDoctrine()->getManager()
               ->createQuery('SELECT p.id, p.paramKey, p.operator, p.paramValue  FROM Berd\DashboardBundle\Entity\Params p
                        WHERE p.requete = :requeteId')
		->setParameter('requeteId', $requeteId);

		try {
			$entity = $query->getResult();
		} catch (\Doctrine\Orm\NoResultException $e) {
			$entity = null;
		}
		
        return array('entity' => $entity, );
	}
	/**
	*   @Route("/testRequete", name="requestlist_testRequete")
    *   @Template("BerdDashboardBundle:RequestList:testRequete.html.twig")
	*/
	public function testRequeteAction(){
		$test = 'SELECT p.nom FROM Berd\PersonnageBundle\Entity\Personnage p WHERE p.niveau >= :minP(3) AND p.niveau <= :maxP(20) AND p.dateNaissance = :dateNaissance("2015-04-17")';
		$min = 3;
		$max = 20;
		$dateNaissance = "2015-04-17";
		
		$query = $this->getDoctrine()->getManager()
               ->createQuery($test)
		->setParameter('minP', $min)
		->setParameter('maxP', $max)
		->setParameter('dateNaissance', $dateNaissance);
		
		try {
			$entity = $query->getResult();
		} catch (\Doctrine\Orm\NoResultException $e) {
			$entity = null;
		}
		var_dump($entity);
		return array('entity' => $entity, );
	}
	
	/**
	*	éxécute des requêtes, sauvegarde et affichent les résultats 
	*
	*   @Route("/executeRequete", name="requestlist_executeRequete")
    *   @Template("BerdDashboardBundle:RequestList:executeRequete.html.twig")
	*/
	public function executeRequeteAction(){
		//je récupère les requêtes selon id de requestlist
		$entity = $this->recupRequeteAction();
		
		$nbRequete = sizeof($entity['entity']);
		$entity2 = array();
		$tabEntity = array();
		$requete = new Requete();
		
		//récupération des paramétres lié au requete retourné
		$this->boucleRecupParam($nbRequete, $entity, $entity2);
		
		//execute chaque requête
		for($cpt = 0; $cpt < $nbRequete; $cpt++){
			$body = $entity['entity'][$cpt]['body'];
			$requeteId = $entity['entity'][$cpt]['id'];
			
			//compte combien de parametre contient cette requête
			$nbParams = sizeof($entity2[$cpt]['entity']);
			
			//initialisent les tableaux à zero
			$key = array();
			$operator = array();
			$value = array();
			$keyValue = array();
			
			//récupération des paramètres selon la requête
			$this->recupKOV($key, $operator, $value, $keyValue, $nbParams, $entity2, $cpt);
			
			//exécute les requetes
			if($nbParams == 1){
				$query = $this->getDoctrine()->getManager()
				   ->createQuery($body)
				   ->setParameter($key[0], $value[0]);

				try {
					//récupère le résultat
					$entity3 = $query->getResult();
					
					//et le nombre de champ contenu dans le résultat
					$nbFields = sizeof($entity3);
					
					//récupère les champs et leur valeurs
					$nameField = $this->recupKeyTabAction(1, $entity3);
					$nameValue = $this->recupValueTabAction($nbFields, $entity3);
					
					//enregistre dans tabEntity nameField et nameValue
					$tabEntity[$cpt] = array(0 => $nameField, 1 => $nameValue,);
					
					//récupère de nouveau les champs
					$nameField = $this->recupKeyTabAction($nbFields, $entity3);
					
					//récupère l'entité d'une réquête en indiquant son id
					$requete = $this->returnEntityRequete($requeteId);
					
					//récupère le nombre d'enregistrement
					$nbTab2 = sizeof($entity3[0]);
					
					//je crée un enregistrement result et resultfield
					//$this->saveResultAnResultFieldsAction($requete, $nbFields, $nbTab2, $nameValue, $nameField)
					
				} catch (\Doctrine\Orm\NoResultException $e) {
					$entity3 = null;
				}
				
			}else if($nbParams >= 2){
				$query = $this->getDoctrine()->getManager()
				   ->createQuery($body)
				   ->setParameters($keyValue);
				try {
					//récupère le résultat
					$entity3 = $query->getResult();
					
					//et le nombre de champ contenu dans le résultat
					$nbFields = sizeof($entity3);
					
					//récupère les champs et leur valeurs
					$nameField = $this->recupKeyTabAction(1, $entity3);
					$nameValue = $this->recupValueTabAction($nbFields, $entity3);
					
					//enregistre dans tabEntity nameField et nameValue
					$tabEntity[$cpt] = array(0 => $nameField, 1 => $nameValue,);
					
					//récupère de nouveau les champs
					$nameField = $this->recupKeyTabAction($nbFields, $entity3);
					
					//récupère l'entité d'une réquête en indiquant son id
					$requete = $this->returnEntityRequete($requeteId);
					
					//récupère le nombre d'enregistrement
					$nbTab2 = sizeof($entity3[0]);
					
					//je crée un enregistrement result et resultfield
					//$this->saveResultAnResultFieldsAction($requete, $nbFields, $nbTab2, $nameValue, $nameField);
					
				} catch (\Doctrine\Orm\NoResultException $e) {
					$entity3 = null;
				}
			}
		}
		
        return array('entity' => $entity, 'tabEntity' => $tabEntity, );
	}
	
	/**
	* effectue une boucle afin de récupéré les paramétres lié à une requete
	* 
	*/
	public function boucleRecupParam(&$nbRequete, $entity, &$entity2){
		for($cpt = 0; $cpt < $nbRequete; $cpt++){
			$requeteId = $entity['entity'][$cpt]['id'];
			$entity2[$cpt] = $this->recupParamsAction($requeteId); 	
		}
	}
	
	/**
	*	insert dans chaque tableau les paramKey, operator et paramValue 
	*	@param key passage par référence du tableau key
	*	@param operator passage par référence du tableau operator
	*	@param value passage par référence du tableau value
	*	@param nbParams indique le nombre de params que contient entity2
	*	@param entity2 est le tableau avec lequel on à récupéré les paramêtres 
	*	@param cpt est le compteur indiquant un moment dans une boucle
	*/
	public function recupKOV(&$key, &$operator, &$value, &$keyValue, $nbParams, $entity2, $cpt){
		
		for($cpt2 = 0; $cpt2 < $nbParams; $cpt2++){
				$key[$cpt2] = $entity2[$cpt]['entity'][$cpt2]['paramKey'];
				$operator[$cpt2] = $entity2[$cpt]['entity'][$cpt2]['operator'];
				$value[$cpt2] = $entity2[$cpt]['entity'][$cpt2]['paramValue'];
				$keyValue[$cpt2] = $key[$cpt2];
		}
		$keyValue = array_flip($keyValue);
		for($cpt2 = 0; $cpt2 < $nbParams; $cpt2++){
				$keyValue[$key[$cpt2]] = $value[$cpt2];
		}
	}
	
	/**
	*	cette fonction crée des enregistrements pour les tables Results et ResultFields
	*	@param requete id de requete
	*	@param 
	*/
	public function saveResultAnResultFieldsAction($requete, $nbFields, $nbTab2, $nameValue, $nameField){
		$result = new Results();
		$result = $this->saveResultsAction($requete);
		$this->saveResultFieldsAction($result, $nbFields, $nbTab2, $nameValue, $nameField);	
	}
	
	/**
	*   affichent les résultats de requete lié à un results
	*
	*   @Route("/afficherResultat", name="requestlist_afficherResultat")
    *   @Template("BerdDashboardBundle:RequestList:afficherResultat.html.twig")
	*/
	public function afficherResultatAction($userId = '7OwNzMxcQD'){
		$entity = $this->recupRequeteAction();
		$nbRequete = sizeof($entity['entity']);
		$tabEntity = array();
		
		$resultId = $this->recupResultIdAction($userId);
		
		$nbResult = sizeof($resultId);
		for($cpt = 0; $cpt < $nbResult; $cpt++){
			$results = $resultId[$cpt]['id'];
			$entity3 = $this->recupResultFieldAction($results);
			
			//enregistre dans tabEntity nameField et nameValue
			$tabEntity[$cpt] = $entity3;
		}
		
		return Array('tabEntity' => $tabEntity, );
	}
	
	/**
	*	cette fonction récupère les noms de champ et valeur qui sont associer
	*	@param resultId id d'un results avec lequel ont souhaite effectuer la requete
	*	@return entity retourne les enregistrements récupéré de la table resultFields
	*/
	public function recupResultFieldAction($resultId){
			$query = $this->getDoctrine()->getManager()
				   ->createQuery('SELECT r.fieldName, r.fieldValue  FROM Berd\DashboardBundle\Entity\ResultFields r
							WHERE r.results = :resultId')
			->setParameter('resultId', $resultId);

			try {
				$entity = $query->getResult();
				
			} catch (\Doctrine\Orm\NoResultException $e){
				$entity = null;
			}
			
		$entity = $this->separerField($entity);
		
        return $entity;
	}
	
	/**
	*	sépare les données reçu en deux tableaux
	*	@param le tableau qu'on souhaite séparer
	*	@return un tableau contenant un tableau de keys et un tableau de values
	*/
	public function separerField($entity){
		$nbFields = sizeof($entity);
		$tab = array();
		
		for($cpt = 0; $cpt < $nbFields; $cpt++){
			$listKeys[$cpt] = $entity[$cpt]['fieldName'];
			$listValues[$cpt] = $entity[$cpt]['fieldValue'];
		}
		$listKeys = array_unique($listKeys);
		
		$tab = array('key' => $listKeys, 'value' => $listValues,);
		
		return $tab;
	}
	
	/**
	*	récupère tout les id de results selon la clée étrangère de requete
	*	@param requeteId id de requete qui servira de recherche
	*	@return entity retourne le résultat de la requête
	*/
	public function recupResultIdAction($userId){
		$query = $this->getDoctrine()->getManager()
               ->createQuery('SELECT r.id  FROM Berd\DashboardBundle\Entity\Results r
                        WHERE r.userId = :userId')
		->setParameter('userId', $userId);

		try {
			$resultId = $query->getResult();
		} catch (\Doctrine\Orm\NoResultException $e) {
			$resultId = null;
		}
		
        return $resultId;
		
	}
	
	/**
	*	récupère l'indice d'un tableau associatif
	*	@param nbTab taille du tableau
	*	@param $tab le tableau qu'on souhaite récupéré les indices
    *	@return tabField une tableau contenant les indices récupéré	
	*/
	public function recupKeyTabAction($nbTab, $tab){
		$tabField = array();
		for($cpt = 0; $cpt < $nbTab; $cpt++){
			$tabField[$cpt] = array_keys($tab[$cpt]);
		}
		return $tabField;
	}
	
	/**
	*	récupère les valeurs d'un tableau associatif
	*	@param nbTab taille du tableau
	*	@param $tab le tableau qu'on souhaite récupéré les valeurs
    *	@return tabValue une tableau contenant les valeurs récupéré	
	*/
	public function recupValueTabAction($nbTab, $tab){
		$tabValue = array();
		for($cpt = 0; $cpt < $nbTab; $cpt++){
			$tabValue[$cpt] = array_values($tab[$cpt]);
		}
		return $tabValue;
	}
	
	/**
	*	Sauvegarde les valeurs dans la table Result
	*	@param requete correspond à l'entité de type requete
	*/
	public function saveResultsAction($requete){
		$em= $this->getDoctrine()->getManager();
		$entity = new Results();
		$entity->setFieldList('liste resultat');
		$entity->setDateCreation(new DateTime('05/12/2015'));
		$entity->setRequest('requete 1');
		$entity->setUserId('7OwNzMxcQD');
		$entity->setRequete($requete);
		$em->persist($entity);
		$em->flush();
		
		return $entity;
	}
	
	/**
	*	Sauvegarde les valeurs dans la table ResultFields
	*	@param result correspond à l'entité de type result
	*   @param nbTab correspond au nombre de champs
	*   @param nbTab2 correspond au nombre d'enregistrement
	*	@param nameValue correspond à une liste de valeur d'enregistrement
	*   @param nameField correspond à une liste de nom de champs
	*/
	public function saveResultFieldsAction($result, $nbTab, $nbTab2, $nameValue, $nameField){
		
		for($cpt = 0; $cpt < $nbTab; $cpt++){
			for($cpt2 = 0; $cpt2 < $nbTab2; $cpt2++){
				$em= $this->getDoctrine()->getManager();
				$entity = new ResultFields();
				$entity->setFieldName($nameField[$cpt][$cpt2]);
				$entity->setFieldValue($nameValue[$cpt][$cpt2]);
				$entity->setResults($result);
				$entity->setUserId('7OwNzMxcQD');
				$em->persist($entity);
				$em->flush();
			}
		}
	}
	
	/**
	* Retourne une entité de type requete.
	* @param requeteId permet de selectionner l'enregistrement de la requete à retourner
	* @return un entité de type Requete
	*/
	public function returnEntityRequete($requeteId){
		$entity = new Requete();
		$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:Requete')->find($requeteId);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requete entity.');
        }
        return $entity;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Lists all RequestList entities.
     *
     * @Route("/", name="requestlist")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BerdDashboardBundle:RequestList')->findAll();

        return array(
            'entities1' => $entities,
        );
    }
	
    /**
     * Creates a new RequestList entity.
     *
     * @Route("/create", name="requestlist_create")
     * @Method("POST")
     * @Template("BerdDashboardBundle:RequestList:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new RequestList();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('requestlist_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a RequestList entity.
     *
     * @param RequestList $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RequestList $entity)
    {
        $form = $this->createForm(new RequestListType(), $entity, array(
            'action' => $this->generateUrl('requestlist_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RequestList entity.
     *
     * @Route("/new", name="requestlist_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new RequestList();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RequestList entity.
     *
     * @Route("/{id}", name="requestlist_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:RequestList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RequestList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RequestList entity.
     *
     * @Route("/{id}/edit", name="requestlist_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:RequestList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RequestList entity.');
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
    * Creates a form to edit a RequestList entity.
    *
    * @param RequestList $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RequestList $entity)
    {
        $form = $this->createForm(new RequestListType(), $entity, array(
            'action' => $this->generateUrl('requestlist_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing RequestList entity.
     *
     * @Route("/{id}", name="requestlist_update")
     * @Method("PUT")
     * @Template("BerdDashboardBundle:RequestList:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BerdDashboardBundle:RequestList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RequestList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('requestlist_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a RequestList entity.
     *
     * @Route("/{id}", name="requestlist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BerdDashboardBundle:RequestList')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RequestList entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('requestlist'));
    }

    /**
     * Creates a form to delete a RequestList entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('requestlist_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

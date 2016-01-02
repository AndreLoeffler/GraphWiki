<?php

namespace Binaerpiloten\GraphWikiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Binaerpiloten\GraphWikiBundle\Entity\Page;
use Binaerpiloten\GraphWikiBundle\Form\PageType;


/**
 * Page controller.
 *
 * @Route("/page")
 */
class PageController extends Controller
{
    /**
     * Lists all Page entities.
     *
     * @Route("/", name="page_list")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('BinaerpilotenGraphWikiBundle:Page')->findBy([], ['title' => 'ASC']);
        
        $sorted['A'] = array();        $sorted['B'] = array();        $sorted['C'] = array();
        $sorted['D'] = array();        $sorted['E'] = array();        $sorted['F'] = array();
        $sorted['G'] = array();        $sorted['H'] = array();        $sorted['I'] = array();
        $sorted['J'] = array();        $sorted['K'] = array();        $sorted['L'] = array();
        $sorted['M'] = array();        $sorted['N'] = array();        $sorted['O'] = array();
        $sorted['P'] = array();        $sorted['Q'] = array();        $sorted['R'] = array();
        $sorted['S'] = array();        $sorted['T'] = array();        $sorted['U'] = array();
        $sorted['V'] = array();        $sorted['W'] = array();        $sorted['X'] = array();
        $sorted['Y'] = array();        $sorted['Z'] = array();
                
        foreach ($pages as $p) {
        	$cap = substr($p->getTitle(),0,1);
        	$sorted[$cap][] = $p->getTitle(); 
        }
        
        foreach($sorted as $s) sort($s,SORT_STRING);
        
        
        return $this->render('BinaerpilotenGraphWikiBundle:page:index.html.twig', array(
            'pages' => $sorted,
        ));
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/new", name="page_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('Binaerpiloten\GraphWikiBundle\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	$page->setCreator($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('page_show', array('pagename' => $page->getTitle()));
        }

        return $this->render('BinaerpilotenGraphWikiBundle:page:new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{pagename}", name="page_show")
     * @Method("GET")
     */
    public function showAction($pagename)
    {
    	$repo = $this->getDoctrine()->getRepository('BinaerpilotenGraphWikiBundle:Page');
    	$page = $repo->findOneByTitle($pagename); 
    	
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('BinaerpilotenGraphWikiBundle:page:show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{pagename}/edit", name="page_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $pagename)
    {
    	$repo = $this->getDoctrine()->getRepository('BinaerpilotenGraphWikiBundle:Page');
    	$page = $repo->findOneByTitle($pagename);
    	
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('Binaerpiloten\GraphWikiBundle\Form\PageType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
        	$page->setEditor($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('page_show', array('pagename' => $page->getTitle()));
        }

        return $this->render('BinaerpilotenGraphWikiBundle:page:edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Page entity.
     *
     * @Route("/{pagename}", name="page_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $pagename)
    {
    	$repo = $this->getDoctrine()->getRepository('BinaerpilotenGraphWikiBundle:Page');
    	$page = $repo->findOneByTitle($pagename);
    	
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('page_list');
    }

    /**
     * Creates a form to delete a Page entity.
     *
     * @param Page $page The Page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_delete', array('pagename' => $page->getTitle())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

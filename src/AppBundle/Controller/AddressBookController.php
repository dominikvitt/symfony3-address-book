<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AddressBook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Addressbook controller.
 *
 * @Route("/")
 */
class AddressBookController extends Controller
{
    /**
     * Lists all addressBook entities.
     *
     * @Route("/", name="addressbook_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $addressBooks = $em->getRepository('AppBundle:AddressBook')->findAll();

        return $this->render('addressbook/index.html.twig', array(
            'addressBooks' => $addressBooks,
        ));
    }

    /**
     * Creates a new addressBook entity.
     *
     * @Route("/new", name="addressbook_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $addressBook = new Addressbook();
        $form = $this->createForm('AppBundle\Form\AddressBookType', $addressBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // upload picture 
            /** @var UploadedFile $picture */
            $picture = $form['picture']->getData();

            // this condition is needed because the 'picture' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $newFilename = 'picture-'.uniqid().'.'.$picture->guessExtension();

                // Move the file to the directory where pictures are stored
                try {
                    $picture->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'pictureFilename' property to store the PDF file name
                // instead of its contents
                $addressBook->setPicture($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($addressBook);
            $em->flush();

            return $this->redirectToRoute('addressbook_show', array('id' => $addressBook->getId()));
        }

        return $this->render('addressbook/new.html.twig', array(
            'addressBook' => $addressBook,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a addressBook entity.
     *
     * @Route("/{id}", name="addressbook_show")
     * @Method("GET")
     */
    public function showAction(AddressBook $addressBook)
    {
        $deleteForm = $this->createDeleteForm($addressBook);

        return $this->render('addressbook/show.html.twig', array(
            'addressBook' => $addressBook,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing addressBook entity.
     *
     * @Route("/{id}/edit", name="addressbook_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AddressBook $addressBook)
    {
        $deleteForm = $this->createDeleteForm($addressBook);
        $editForm = $this->createForm('AppBundle\Form\AddressBookType', $addressBook);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // upload picture 
            /** @var UploadedFile $picture */
            $picture = $editForm['picture']->getData();

            // this condition is needed because the 'picture' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $newFilename = 'picture-'.uniqid().'.'.$picture->guessExtension();

                // Move the file to the directory where pictures are stored
                try {
                    $picture->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'pictureFilename' property to store the PDF file name
                // instead of its contents
                $addressBook->setPicture($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('addressbook_edit', array('id' => $addressBook->getId()));
        }

        return $this->render('addressbook/edit.html.twig', array(
            'addressBook' => $addressBook,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a addressBook entity.
     *
     * @Route("/{id}", name="addressbook_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AddressBook $addressBook)
    {
        $form = $this->createDeleteForm($addressBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($addressBook);
            $em->flush();
        }

        return $this->redirectToRoute('addressbook_index');
    }

    /**
     * Creates a form to delete a addressBook entity.
     *
     * @param AddressBook $addressBook The addressBook entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AddressBook $addressBook)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('addressbook_delete', array('id' => $addressBook->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

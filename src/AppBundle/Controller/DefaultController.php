<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Exp;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/{id}", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var $user User
         */
        $user = $em->getRepository('AppBundle:User')->findOneBy(['id' => $id]);

        $user->setFullname('OverSeas media');

        // save the records that are in the database first to compare them with the new one the user sent
        // make sure this line comes before the $form->handleRequest();
        $orignalExp = new ArrayCollection();
        foreach ($user->getExp() as $exp) {
            $orignalExp->add($exp);
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // get rid of the ones that the user got rid of in the interface (DOM)
            foreach ($orignalExp as $exp) {
                // check if the exp is in the $user->getExp()
//                dump($user->getExp()->contains($exp));
                if ($user->getExp()->contains($exp) === false) {
                    $em->remove($exp);
                }
            }
            $em->persist($user);
            $em->flush();
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

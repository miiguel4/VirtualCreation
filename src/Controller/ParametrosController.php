<?php

namespace App\Controller;

use App\Entity\Parametros;
use App\Form\ParametrosType;
use App\Repository\ParametrosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parametros")
 */
class ParametrosController extends AbstractController {
    /**
     * @Route("/", name="app_parametros_index", methods={"GET"})
     */
    public function index(ParametrosRepository $parametrosRepository): Response {
        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        foreach ($this->getUser()->getRoles() as $rol) {
            if ($rol == "ROLE_ADMIN") {
                return $this->render('parametros/index.html.twig', [
                    'parametros' => $parametrosRepository->findAll(),
                ]);
            } else {
                return $this->redirectToRoute('app_inicio', [], Response::HTTP_SEE_OTHER);
            }
        }
    }

    /**
     * @Route("/new", name="app_parametros_new", methods={"GET", "POST"})
     */
    
    public function new(Request $request, ParametrosRepository $parametrosRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        foreach ($this->getUser()->getRoles() as $rol) {
            if ($rol == "ROLE_ADMIN") {
                $parametro = new Parametros();
                $form = $this->createForm(ParametrosType::class, $parametro);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $parametrosRepository->add($parametro, true);

                    return $this->redirectToRoute('app_parametros_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->renderForm('parametros/new.html.twig', [
                    'parametro' => $parametro,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('app_inicio', [], Response::HTTP_SEE_OTHER);
            }
        }
        
    }

    /**
     * @Route("/{id}/edit", name="app_parametros_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Parametros $parametro, ParametrosRepository $parametrosRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        foreach ($this->getUser()->getRoles() as $rol) {
            if ($rol == "ROLE_ADMIN") {
                $form = $this->createForm(ParametrosType::class, $parametro);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $parametrosRepository->add($parametro, true);

                    return $this->redirectToRoute('app_parametros_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->renderForm('parametros/edit.html.twig', [
                    'parametro' => $parametro,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('app_inicio', [], Response::HTTP_SEE_OTHER);
            }
        }
    }

    /**
     * @Route("/{id}", name="app_parametros_delete", methods={"POST"})
     */
    public function delete(Request $request, Parametros $parametro, ParametrosRepository $parametrosRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        foreach ($this->getUser()->getRoles() as $rol) {
            if ($rol == "ROLE_ADMIN") {
                if ($this->isCsrfTokenValid('delete'.$parametro->getId(), $request->request->get('_token'))) {
                    $parametrosRepository->remove($parametro, true);
                }
        
                return $this->redirectToRoute('app_parametros_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_inicio', [], Response::HTTP_SEE_OTHER);
            }
        }
        
    }
}

<?php

namespace App\Controller;

use App\Form\Products\ImportType;
use App\Service\Products\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products')]
final class ProductsController extends AbstractController
{
    #[Route('/import')]
    public function import(Request $request, ImportService $importService): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $importService->addFile($form->getData());
            $this->addFlash('success','The file has been imported');
        }

        return $this->render('products/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

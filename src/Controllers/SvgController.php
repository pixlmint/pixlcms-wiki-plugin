<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Contracts\RequestInterface;
use Nacho\Controllers\AbstractController;
use Nacho\Exceptions\BadRequestHttpException;
use Nacho\Exceptions\MethodNotAllowedHttpException;
use Nacho\Exceptions\UnauthorizedHttpException;
use Nacho\Helpers\Utils;
use Nacho\Models\HttpMethod;
use Nacho\Models\HttpResponse;
use PixlMint\CMS\Helpers\CustomUserHelper;
use PixlMint\WikiPlugin\Model\SvgDrawing;
use PixlMint\WikiPlugin\Repository\SvgDrawingRepository;

class SvgController extends AbstractController
{
    /**
     * POST `/api/admin/svg/store-data`
     */
    public function storeSvgData(RequestInterface $request, SvgDrawingRepository $svgRepository): HttpResponse
    {
        if (!$this->isGranted(CustomUserHelper::ROLE_EDITOR)) {
            throw new UnauthorizedHttpException("You are not authenticated");
        }
        if (!$request->isMethod(HttpMethod::POST)) {
            throw new MethodNotAllowedHttpException("Only POST requests allowed");
        }
        if (!$request->getBody()->has('drawing')) {
            throw new BadRequestHttpException("Svg data drawing argument not supplied");
        }

        $drawing = $request->getBody()->get('drawing');
        if (Utils::isJson($drawing)) {
            $drawing = json_decode($drawing, true);
        }
        if (is_string($drawing['data'])) {
            $drawing['data'] = json_decode($drawing['data'], true);
        }

        $drawingObj = $svgRepository->findBySvgPath($drawing['svg']);
        if ($drawingObj) {
            $drawingObj->setData($drawing['data']);
        } else {
            $drawingObj = new SvgDrawing(0, $drawing['svg'], $drawing['data']);
        }
        $svgRepository->set($drawingObj);

        return $this->json(['message' => 'Success']);
    }


    /**
     * GET `/api/admin/svg/load-data`
     */
    public function loadSvgData(RequestInterface $request, SvgDrawingRepository $svgRepository): HttpResponse
    {
        if (!$this->isGranted(CustomUserHelper::ROLE_EDITOR)) {
            throw new UnauthorizedHttpException("You are not authenticated");
        }
        if (!$request->getBody()->has('media')) {
            throw new BadRequestHttpException("Svg data drawing argument not supplied");
        }

        $media = $request->getBody()->get('media');
        $svg = $svgRepository->findBySvgPath($media);

        if (is_null($svg)) {
            return $this->json(['message' => "cannot find $media"], 404);
        }

        return $this->json(['data' => $svg->getData()]);
    }
}

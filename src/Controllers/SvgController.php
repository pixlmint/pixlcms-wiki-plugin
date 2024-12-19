<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Contracts\RequestInterface;
use Nacho\Controllers\AbstractController;
use Nacho\Helpers\Utils;
use Nacho\Models\HttpMethod;
use Nacho\Models\HttpResponse;
use Nacho\Models\HttpResponseCode;
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
            return $this->json(['message' => 'You are not authenticated'], 401);
        }
        if (!$request->isMethod(HttpMethod::POST)) {
            return $this->json(['message' => 'invalid request method', HttpResponseCode::METHOD_NOT_ALLOWED]);
        }
        if (!$request->getBody()->has('drawing') && !$request->getBody()->has('drawing')) {
            return $this->json(['message' => 'Svg data drawing argument not supplied'], HttpResponseCode::BAD_REQUEST);
        }

        $drawing = $request->getBody()->get('drawing');
        if (Utils::isJson($drawing)) {
            $drawing = json_decode($drawing, true);
        }

        $drawingObj = $svgRepository->findBySvgPath($drawing['svg']);
        if ($drawingObj) {
            $drawingObj->setSvg($drawing['svg']);
            $drawingObj->setData($drawing['data']);
        } else {
            $drawingObj = new SvgDrawing(0, $drawing['svg'], $drawing['data']);
        }
        $svgRepository->set($drawingObj);

        return $this->json(['message' => 'Success']);
    }
}

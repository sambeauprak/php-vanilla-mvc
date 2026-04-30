<?php

function indexPage($twig)
{
    return function () use ($twig) {
        return $twig->render('pages/index.html.twig');
    };
}

function bioPage($twig)
{
    return function () use ($twig) {
        return $twig->render('pages/bio.html.twig');
    };
}

function projectsPage($twig)
{
    return function () use ($twig) {
        return $twig->render('pages/projects.html.twig');
    };
}

function contactPage($twig)
{
    return function () use ($twig) {
        return $twig->render('pages/contact.html.twig');
    };
}
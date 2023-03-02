<?php

namespace hmcswModule\legalInformation\src;

use hmcsw\controller\api\ApiController;
use hmcsw\controller\web\WebController;
use hmcsw\routing\Routing;
use hmcsw\service\module\ModuleGeneralRepository;
use hmcsw\service\templates\LanguageService;
use hmcsw\service\templates\SeoService;

class legalInformation implements ModuleGeneralRepository
{

  private readonly array $config;

  public function __construct()
  {
    $this->config = [];
  }
  
  public static function getImprint(): array
  {
    if (!file_exists(__DIR__ . "/../config/imprint.yaml")) return [];
    $file = file_get_contents(__DIR__ . "/../config/imprint.yaml");

    return yaml_parse($file);
  }
  
  public static function getPrivacy(): array
  {
    if (!file_exists(__DIR__ . "/../config/privacy.yaml")) return [];
    $file = file_get_contents(__DIR__ . "/../config/privacy.yaml");

    return yaml_parse($file);
  }
  
  public static function getTerms(): array
  {
    if (!file_exists(__DIR__ . "/../config/terms.yaml")) return [];
    $file = file_get_contents(__DIR__ . "/../config/terms.yaml");

    return yaml_parse($file);
  }
  
  public static function getWithdrawal(): array
  {
    if (!file_exists(__DIR__ . "/../config/withdrawal.yaml")) return [];

    $file = file_get_contents(__DIR__ . "/../config/withdrawal.yaml");

    return yaml_parse($file);
  }
  
  public static function getParentInfo(): array
  {
    if (!file_exists(__DIR__ . "/../config/parents.yaml")) return [];
    $file = file_get_contents(__DIR__ . "/../config/parents.yaml");

    return yaml_parse($file);
  }

  public function addApiRoutes(Routing $routing, ApiController $apiController): void
  {

  }

  public function addRoutes(Routing $routing, WebController $webController): void
  {
    $module = $this;

    $routing->router->any('/legal/imprint', function() use ($webController, $module) {
      $text = $module->getImprint();

      $webController->renderPage("legal/imprint.twig", ["all" => $text], LanguageService::getMessage('site.legal.imprint'));
    });
    $routing->router->any('/legal/privacy', function() use ($webController, $module) {
      $text = $module->getPrivacy();

      $webController->renderPage("legal/privacy.twig", ["all" => $text], LanguageService::getMessage('site.legal.privacy'));
    });
    $routing->router->any('/legal/terms', function () use ($webController, $module) {
      $text = $module->getTerms();

      $webController->renderPage("legal/terms.twig", ["all" => $text], LanguageService::getMessage('site.legal.terms'));
    });
    $routing->router->any('/legal/withdrawal', function () use ($webController, $module) {
      $text = $module->getWithdrawal();

      $webController->renderPage("legal/withdrawal.twig", ["all" => $text], LanguageService::getMessage('site.legal.withdrawal'));
    });
    $routing->router->any('/legal/parents', function () use ($webController, $module) {
      $text = $module->getParentInfo();

      $webController->renderPage("legal/parents.twig", ["all" => $text], LanguageService::getMessage('site.legal.parents'));
    });
  }

  public function initial(): void
  {
    // TODO: Implement initial() method.
  }

  public function startModule(): bool
  {
    SeoService::addPage("Imprint", "legal/imprint");
    SeoService::addPage("Privacy", "legal/privacy");
    SeoService::addPage("Terms", "legal/terms");
    SeoService::addPage("Withdrawal", "legal/withdrawal");
    SeoService::addPage("Parents", "legal/parents");

    return true;
  }

  public function getMessages(string $lang): array|bool
  {
    if (!file_exists(__DIR__ . '/../messages/' . $lang . '.json')) {
      return false;
    }

    return json_decode(file_get_contents(__DIR__ . '/../messages/' . $lang . '.json'), true);
  }

  public function getModuleInfo(): array
  {
    return json_decode(file_get_contents(__DIR__ . '/../module.json'), true);
  }

  public function getProperties(): array
  {
    return json_decode(file_get_contents(__DIR__ . '/../config/config.json'), true);
  }

  public function getConfig(): array
  {
    return $this->config;
  }
}
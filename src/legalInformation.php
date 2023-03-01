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
  private WebController $webController;

  public function __construct()
  {
    $this->config = [];
  }

  public function imprint(): void
  {
    $text = $this->getImprint();

    $this->webController->renderPage("legal/imprint.twig", ["all" => $text], LanguageService::getMessage('site.legal.imprint'),);
  }

  public static function getImprint(): array
  {
    if (!file_exists(__DIR__ . "/../config/imprint.yaml")) return [];
    $file = file_get_contents(__DIR__ . "/../config/imprint.yaml");

    return yaml_parse($file);
  }

  public function privacy(): void
  {
    $text = $this->getPrivacy();

    $this->webController->renderPage("legal/privacy.twig", ["all" => $text], LanguageService::getMessage('site.legal.privacy'),);
  }

  public static function getPrivacy(): array
  {
    if (!file_exists(__DIR__ . "/../config/privacy.yaml")) return [];
    $file = file_get_contents(__DIR__ . "/../config/privacy.yaml");

    return yaml_parse($file);
  }

  public function terms(): void
  {
    $text = $this->getTerms();

    $this->webController->renderPage("legal/terms.twig", ["all" => $text], LanguageService::getMessage('site.legal.terms'),);
  }

  public static function getTerms(): array
  {
    if (!file_exists(__DIR__ . "/../config/terms.yaml")) return [];
    $file = file_get_contents(__DIR__ . "/../config/terms.yaml");

    return yaml_parse($file);
  }

  public function withdrawal(): void
  {
    $text = $this->getWithdrawal();

    $this->webController->renderPage("legal/withdrawal.twig", ["all" => $text], LanguageService::getMessage('site.legal.withdrawal'),);
  }

  public static function getWithdrawal(): array
  {
    if (!file_exists(__DIR__ . "/../config/withdrawal.yaml")) return [];

    $file = file_get_contents(__DIR__ . "/../config/withdrawal.yaml");

    return yaml_parse($file);
  }

  public function parents(): void
  {
    $text = $this->getParentInfo();

    $this->webController->renderPage("legal/parents.twig", ["all" => $text], LanguageService::getMessage('site.legal.parents'),);
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
    $this->webController = $webController;
    $routing->router->any('/legal/imprint', [$this, 'imprint']);
    $routing->router->any('/legal/privacy', [$this, 'privacy']);
    $routing->router->any('/legal/terms', [$this, 'terms']);
    $routing->router->any('/legal/withdrawal', [$this, 'withdrawal']);
    $routing->router->any('/legal/parents', [$this, 'parents']);
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
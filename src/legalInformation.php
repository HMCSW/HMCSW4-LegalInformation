<?php

namespace hmcswModule\legalInformation\src;

use hmcsw\hmcsw4;
use hmcsw\routing\routing;
use hmcsw\service\general\faqService;
use hmcsw\service\general\event\Events;
use hmcsw\objects\user\invoice\Invoice;
use hmcsw\service\templates\SeoService;
use hmcsw\service\templates\twigService;
use hmcsw\service\templates\LanguageService;
use hmcsw\service\general\event\EventService;
use hmcsw\service\module\moduleGeneralRepository;

class legalInformation implements moduleGeneralRepository
{

  private readonly array $config;

  public function imprint (): void
  {
    $text = $this->getImprint();

    twigService::renderPage("legal/imprint.twig", ["all" => $text], LanguageService::getMessage('site.legal.imprint'),);
  }

  public function privacy (): void
  {
    $text = $this->getPrivacy();

    twigService::renderPage("legal/privacy.twig", ["all" => $text], LanguageService::getMessage('site.legal.privacy'),);
  }

  public function terms (): void
  {
    $text = $this->getTerms();

    twigService::renderPage("legal/terms.twig", ["all" => $text], LanguageService::getMessage('site.legal.terms'),);
  }

  public function withdrawal (): void
  {
    $text = $this->getWithdrawal();

    twigService::renderPage("legal/withdrawal.twig", ["all" => $text], LanguageService::getMessage('site.legal.withdrawal'),);
  }

  public function parents (): void
  {
    $text = $this->getParentInfo();

    twigService::renderPage("legal/parents.twig", ["all" => $text], LanguageService::getMessage('site.legal.parents'),);
  }

  public function addRoutes (routing $routing): void
  {
    $routing->router->any('/legal/imprint', [$this, 'imprint']);
    $routing->router->any('/legal/privacy', [$this, 'privacy']);
    $routing->router->any('/legal/terms', [$this, 'terms']);
    $routing->router->any('/legal/withdrawal', [$this, 'withdrawal']);
    $routing->router->any('/legal/parents', [$this, 'parents']);
  }

  public function addApiRoutes (routing $routing): void
  {
    // TODO: Implement addApiRoutes() method.
  }

  public function initial (): void
  {
    // TODO: Implement initial() method.
  }

  public function __construct ()
  {
    $this->config = [];
  }

  public function startModule (): bool
  {
    SeoService::addPage("Imprint", "legal/imprint");
    SeoService::addPage("Privacy", "legal/privacy");
    SeoService::addPage("Terms", "legal/terms");
    SeoService::addPage("Withdrawal", "legal/withdrawal");
    SeoService::addPage("Parents", "legal/parents");

    return true;
  }

  public function getMessages(string $lang): array|bool {
    if(!file_exists(__DIR__.'/../messages/'.$lang.'.json')){
      return false;
    }

    return json_decode(file_get_contents(__DIR__.'/../messages/'.$lang.'.json'), true);
  }

  public function getModuleInfo (): array
  {
    return json_decode(file_get_contents(__DIR__.'/../module.json'), true);
  }

  public function getProperties (): array
  {
    return json_decode(file_get_contents(__DIR__.'/../config/config.json'), true);
  }

  public function getConfig (): array
  {
    return $this->config;
  }



  public static function getImprint(): array
  {
    if(!file_exists(__DIR__."/../config/imprint.yaml")) return [];
    $file = file_get_contents(__DIR__."/../config/imprint.yaml");

    return yaml_parse($file);
  }

  public static function getPrivacy(): array
  {
    if(!file_exists(__DIR__."/../config/privacy.yaml")) return [];
    $file = file_get_contents(__DIR__."/../config/privacy.yaml");

    return yaml_parse($file);
  }

  public static function getWithdrawal(): array
  {
    if(!file_exists(__DIR__."/../config/withdrawal.yaml")) return [];

    $file = file_get_contents(__DIR__."/../config/withdrawal.yaml");

    return yaml_parse($file);
  }

  public static function getTerms(): array
  {
    if(!file_exists(__DIR__."/../config/terms.yaml")) return [];
    $file = file_get_contents(__DIR__."/../config/terms.yaml");

    return yaml_parse($file);
  }

  public static function getParentInfo(): array
  {
    if(!file_exists(__DIR__."/../config/parents.yaml")) return [];
    $file = file_get_contents(__DIR__."/../config/parents.yaml");

    return yaml_parse($file);
  }
}
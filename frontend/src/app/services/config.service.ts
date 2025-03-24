import { Injectable } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {
  constructor(private translateService: TranslateService) {
    this.translateService.setDefaultLang('hu');
    this.translateService.use(localStorage.getItem('lang') || 'hu');
  }

  switchLanguage(language: string) {
    this.translateService.use(language);
    localStorage.setItem('lang', language);
  }
}

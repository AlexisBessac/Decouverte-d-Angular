import { ɵHTTP_ROOT_INTERCEPTOR_FNS } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, RouterLink, RouterLinkActive, FormsModule],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  
  texteRecherche: string = "";
  router: Router = inject(Router)

  onRecherche(){
    this.router.navigate(['/accueil', this.texteRecherche])
  }
}

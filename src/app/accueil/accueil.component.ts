import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import {MatCardModule} from '@angular/material/card';
import {MatIconModule} from '@angular/material/icon';
import { ActivatedRoute, RouterLink } from '@angular/router';


@Component({
  selector: 'app-accueil',
  standalone: true,
  imports: [HttpClientModule, MatCardModule, MatButtonModule, MatIconModule, RouterLink],
  templateUrl: './accueil.component.html',
  styleUrl: './accueil.component.scss'
})
export class AccueilComponent {
  route:ActivatedRoute = inject(ActivatedRoute)
  
  listeProduit:any = [];
  
  http:HttpClient = inject(HttpClient);

  ngOnInit() {
    this.route.params.subscribe(parametres => {
      if(parametres['recherche']){
        this.http.get("http://backendangular/recherche-produit.php?recherche=" + parametres['recherche'])
          .subscribe(listeProduit => this.listeProduit = listeProduit); 
      } else {
        this.rafraichirListeProduit();
      }
    })
  }

  rafraichirListeProduit(): any {
    this.http.get("http://backendangular/liste-produit.php")
      .subscribe(listeProduit => this.listeProduit = listeProduit);
  }

  onClickSupprimer(idProduit: number){
    this.http.delete('http://backendangular/supprimer-produit.php?id=' + idProduit)
    .subscribe((resultat) => this.rafraichirListeProduit);
  }
}
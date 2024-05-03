import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatInputModule } from '@angular/material/input';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-edit-produit',
  standalone: true,
  imports: [MatInputModule, MatButtonModule, FormsModule, ReactiveFormsModule, HttpClientModule, MatIconModule],
  templateUrl: './edit-produit.component.html',
  styleUrl: './edit-produit.component.scss'
})
export class EditProduitComponent {

  formbuilder: FormBuilder = inject(FormBuilder);

  http: HttpClient = inject(HttpClient)

  router: Router = inject (Router);

  route: ActivatedRoute = inject(ActivatedRoute);

  idProduit: number | null = null;

  imageExistanteBdd: string  | null = null;

  suppressionImageExistanteBdd: boolean = false;

  suppressionImageExistante: string = '';

  ngOnInit(){
    this.route.params.subscribe(parametres => {

      if(parametres['id'] != null && !isNaN(parametres['id'])){
        this.idProduit = parametres['id']
        
        this.http.get('http://backendangular/produit.php?id=' + this.idProduit)
        .subscribe((produit: any) => {
          this.formulaire.patchValue(produit)
          this.imageExistanteBdd = produit.image;
        })
      }
    });
  }

  formulaire: FormGroup = this.formbuilder.group({
    nom: ['', [Validators.required, Validators.minLength(3), Validators.maxLength(100)]],
    description: ['', []],
    prix: [1, [Validators.required, Validators.min(0.01)]]
  })

  fichierSelectionne: File | null = null

  onAjoutProduit() {
    
    const data = new FormData();

    data.append("produit", JSON.stringify(this.formulaire.value))
    
    if(this.suppressionImageExistante){
      data.append('supprimer_image', 'true')
    }

    if (this.formulaire.valid) {
      
      const url: string = this.idProduit
      ? 'http://backendangular/modifier-produit.php/?id=' + this.idProduit
      : 'http://backendangular/ajout-produit.php'
      
      this.http.post(url, data)
      .subscribe((resultat) => {
        this.router.navigateByUrl('/accueil');
      });
    }
  }

  onSelectionFichier(evenement: any){
    this.fichierSelectionne = evenement.target.files[0]
  }

  onSupressionImage(){
    this.suppressionImageExistanteBdd = true;
  }
}

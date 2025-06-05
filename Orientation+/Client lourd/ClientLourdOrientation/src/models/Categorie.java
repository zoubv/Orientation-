package models;

import java.sql.Timestamp;

public class Categorie {
    private int id;
    private String nomDomaine;
    private String nomIcone;
    private String description;
    private Timestamp dateAjout; // Ajout de l'attribut date d'ajout

    // Constructeur avec tous les champs
    public Categorie(int id, String nomDomaine, String nomIcone, String description, Timestamp dateAjout) {
        this.id = id;
        this.nomDomaine = nomDomaine;
        this.nomIcone = nomIcone;
        this.description = description;
        this.dateAjout = dateAjout;
    }

    // Constructeur sans ID (utilisé lors de l'ajout de nouvelles catégories, date générée automatiquement)
    public Categorie(String nomDomaine, String nomIcone, String description) {
        this.nomDomaine = nomDomaine;
        this.nomIcone = nomIcone;
        this.description = description;
        this.dateAjout = new Timestamp(System.currentTimeMillis()); // Date d'ajout actuelle
    }

    // Getters
    public int getId() {
        return id;
    }

    public String getNomDomaine() {
        return nomDomaine;
    }

    public String getNomIcone() {
        return nomIcone;
    }

    public String getDescription() {
        return description;
    }

    public Timestamp getDateAjout() {
        return dateAjout;
    }
}

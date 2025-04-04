package models;

public class Categorie {
    private int id;
    private String nomDomaine;
    private String nomIcone;
    private String description;

    // Constructeur avec tous les champs
    public Categorie(int id, String nomDomaine, String nomIcone, String description) {
        this.id = id;
        this.nomDomaine = nomDomaine;
        this.nomIcone = nomIcone;
        this.description = description;
    }

    // Constructeur sans ID (utilisé lors de l'ajout de nouvelles catégories)
    public Categorie(String nomDomaine, String nomIcone, String description) {
        this.nomDomaine = nomDomaine;
        this.nomIcone = nomIcone;
        this.description = description;
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
}

package models;

public class Metier {
    private int id;
    private int idCategorie;
    private String nom;
    private String nomIcone;

    public Metier(int id, int idCategorie, String nom, String nomIcone) {
        this.id = id;
        this.idCategorie = idCategorie;
        this.nom = nom;
        this.nomIcone = nomIcone;
    }

    public int getId() { return id; }
    public int getIdCategorie() { return idCategorie; }
    public String getNom() { return nom; }
    public String getNomIcone() { return nomIcone; }
}

package models;

public class FichierPDF {
    private int id;
    private String nom;
    private String description;
    private byte[] contenu;
    private int idCategorie;

    public FichierPDF(int id, String nom, String description, byte[] contenu, int idCategorie) {
        this.id = id;
        this.nom = nom;
        this.description = description;
        this.contenu = contenu;
        this.idCategorie = idCategorie;
    }

    public int getId() { return id; }
    public String getNom() { return nom; }
    public String getDescription() { return description; }
    public byte[] getContenu() { return contenu; }
    public int getIdCategorie() { return idCategorie; }
}

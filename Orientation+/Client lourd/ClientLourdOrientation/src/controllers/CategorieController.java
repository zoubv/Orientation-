package controllers;

import models.Categorie;
import utils.DBConnection;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class CategorieController {

    // Récupère toutes les catégories depuis la base de données
    public static List<Categorie> getAllCategories() {
        List<Categorie> categories = new ArrayList<>();
        Connection conn = DBConnection.getConnection();

        try {
            String query = "SELECT * FROM categories ORDER BY nom_domaine"; // Tri par nom
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(query);

            while (rs.next()) {
                categories.add(new Categorie(
                    rs.getInt("id_categories"),
                    rs.getString("nom_domaine"),
                    rs.getString("nom_icone"),
                    rs.getString("description"),
                    rs.getTimestamp("date_ajout") // Ajout de la date d'ajout
                ));
            }
            rs.close();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return categories;
    }

    // Ajoute une catégorie à la base de données avec la date d'ajout automatique
    public static void addCategorie(Categorie categorie) {
        Connection conn = DBConnection.getConnection();
        try {
            String query = "INSERT INTO categories (nom_domaine, nom_icone, description, date_ajout) VALUES (?, ?, ?, ?)";
            PreparedStatement stmt = conn.prepareStatement(query);
            stmt.setString(1, categorie.getNomDomaine());
            stmt.setString(2, categorie.getNomIcone());
            stmt.setString(3, categorie.getDescription());
            stmt.setTimestamp(4, new Timestamp(System.currentTimeMillis())); // Ajout automatique de la date
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    // Supprime une catégorie de la base de données par son ID
    public static void deleteCategorie(int categorieId) {
        Connection conn = DBConnection.getConnection();
        try {
            String query = "DELETE FROM categories WHERE id_categories = ?";
            PreparedStatement stmt = conn.prepareStatement(query);
            stmt.setInt(1, categorieId);
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    // Récupère une catégorie par son ID
    public static Categorie getCategorieById(int id) {
        Categorie categorie = null;
        Connection conn = DBConnection.getConnection();
        try {
            String query = "SELECT * FROM categories WHERE id_categories = ?";
            PreparedStatement stmt = conn.prepareStatement(query);
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();

            if (rs.next()) {
                categorie = new Categorie(
                    rs.getInt("id_categories"),
                    rs.getString("nom_domaine"),
                    rs.getString("nom_icone"),
                    rs.getString("description"),
                    rs.getTimestamp("date_ajout") // Récupération de la date
                );
            }

            rs.close();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return categorie;
    }
 // Récupère tous les noms de domaine distincts depuis la base de données
    public static List<String> getAllDomaines() {
        List<String> domaines = new ArrayList<>();
        Connection conn = DBConnection.getConnection();

        try {
            String query = "SELECT DISTINCT nom_domaine FROM categories";
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(query);

            while (rs.next()) {
                domaines.add(rs.getString("nom_domaine"));
            }
            rs.close();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return domaines;
    }

}

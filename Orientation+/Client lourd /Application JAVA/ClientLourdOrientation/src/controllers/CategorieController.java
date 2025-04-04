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
            String query = "SELECT * FROM categories";
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(query);

            while (rs.next()) {
                categories.add(new Categorie(
                    rs.getInt("id_categories"),
                    rs.getString("nom_domaine"),
                    rs.getString("nom_icone"),
                    rs.getString("description")
                ));
            }
            rs.close();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return categories;
    }

    // Ajoute une catégorie à la base de données
    public static void addCategorie(Categorie categorie) {
        Connection conn = DBConnection.getConnection();
        try {
            String query = "INSERT INTO categories (nom_domaine, nom_icone, description) VALUES (?, ?, ?)";
            PreparedStatement stmt = conn.prepareStatement(query);
            stmt.setString(1, categorie.getNomDomaine());
            stmt.setString(2, categorie.getNomIcone());
            stmt.setString(3, categorie.getDescription());
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
                    rs.getString("description")
                );
            }

            rs.close();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return categorie;
    }
}

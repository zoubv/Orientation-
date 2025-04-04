package controllers;

import models.FichierPDF;
import utils.DBConnection;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class FileController {

    public static List<FichierPDF> getAllFiles() {
        List<FichierPDF> fichiers = new ArrayList<>();
        Connection conn = DBConnection.getConnection();

        try {
            String query = "SELECT * FROM fichiers_pdf";
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(query);

            while (rs.next()) {
                fichiers.add(new FichierPDF(
                    rs.getInt("id"),
                    rs.getString("nom_fichier"),
                    rs.getString("description"),
                    rs.getBytes("contenu_fichier"),
                    rs.getInt("id_categorie")
                ));
            }
            rs.close();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return fichiers;
    }

    public static void addFile(FichierPDF fichier) {
        Connection conn = DBConnection.getConnection();
        try {
            String query = "INSERT INTO fichiers_pdf (nom_fichier, description, contenu_fichier, id_categorie) VALUES (?, ?, ?, ?)";
            PreparedStatement stmt = conn.prepareStatement(query);
            stmt.setString(1, fichier.getNom());
            stmt.setString(2, fichier.getDescription());
            stmt.setBytes(3, fichier.getContenu());
            stmt.setInt(4, fichier.getIdCategorie());
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void deleteFile(int id) {
        Connection conn = DBConnection.getConnection();
        try {
            String query = "DELETE FROM fichiers_pdf WHERE id = ?";
            PreparedStatement stmt = conn.prepareStatement(query);
            stmt.setInt(1, id);
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static List<String[]> getCategories() {
        List<String[]> categories = new ArrayList<>();
        Connection conn = DBConnection.getConnection();

        try {
            String query = "SELECT id_categories, nom_domaine FROM categories";
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(query);

            while (rs.next()) {
                categories.add(new String[]{String.valueOf(rs.getInt("id_categories")), rs.getString("nom_domaine")});
            }
            rs.close();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return categories;
    }
}

package controllers;

import models.Metier;
import utils.DBConnection;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class MetierController {

    public static List<Metier> getAllMetiers() {
        List<Metier> metiers = new ArrayList<>();
        Connection conn = DBConnection.getConnection();

        try {
            String query = "SELECT * FROM metiers";
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(query);

            while (rs.next()) {
                metiers.add(new Metier(
                    rs.getInt("id_metier"),
                    rs.getInt("id_categories"),
                    rs.getString("nom_metier"),
                    rs.getString("nom_icone")
                ));
            }
            rs.close();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return metiers;
    }

    public static void addMetier(Metier metier) {
        Connection conn = DBConnection.getConnection();
        try {
            String query = "INSERT INTO metiers (id_categories, nom_metier, nom_icone) VALUES (?, ?, ?)";
            PreparedStatement stmt = conn.prepareStatement(query);
            stmt.setInt(1, metier.getIdCategorie());
            stmt.setString(2, metier.getNom());
            stmt.setString(3, metier.getNomIcone());
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void deleteMetier(int metierId) {
        Connection conn = DBConnection.getConnection();
        try {
            String query = "DELETE FROM metiers WHERE id_metier = ?";
            PreparedStatement stmt = conn.prepareStatement(query);
            stmt.setInt(1, metierId);
            stmt.executeUpdate();
            stmt.close();
            System.out.println("Métier supprimé avec l'ID: " + metierId);
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

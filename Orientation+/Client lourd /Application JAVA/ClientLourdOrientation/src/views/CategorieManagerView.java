package views;

import controllers.CategorieController;
import models.Categorie;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.util.List;

public class CategorieManagerView extends JFrame {
    private JTable table;
    private DefaultTableModel model;
    private JComboBox<String> categoryBox;

    public CategorieManagerView() {
        setTitle("Gestion des Catégories");
        setSize(600, 400);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLocationRelativeTo(null);

        model = new DefaultTableModel();
        table = new JTable(model);

        // Ajout des boutons Ajouter et Supprimer
        JButton addButton = new JButton("Ajouter Catégorie");
        addButton.addActionListener(this::handleAdd);

        JButton deleteButton = new JButton("Supprimer Catégorie");
        deleteButton.addActionListener(this::handleDelete);

        JPanel topPanel = new JPanel();
        topPanel.add(addButton);
        topPanel.add(deleteButton);

        add(topPanel, BorderLayout.NORTH);
        add(new JScrollPane(table), BorderLayout.CENTER);

        updateView();
        setVisible(true);
    }

    private void updateView() {
        model.setRowCount(0);
        model.setColumnCount(0);

        // Mise à jour des colonnes et lignes de la table
        model.setColumnIdentifiers(new Object[]{"ID", "Nom Domaine", "Nom Icône", "Description"});
        List<Categorie> categories = CategorieController.getAllCategories();
        for (Categorie categorie : categories) {
            model.addRow(new Object[]{
                categorie.getId(),
                categorie.getNomDomaine(),
                categorie.getNomIcone(),
                categorie.getDescription()
            });
        }
    }

    private void handleAdd(ActionEvent e) {
        JTextField nomDomaineField = new JTextField();
        JTextField nomIconeField = new JTextField();
        JTextArea descriptionField = new JTextArea();

        Object[] message = {
            "Nom Domaine:", nomDomaineField,
            "Nom Icône:", nomIconeField,
            "Description:", descriptionField
        };

        // Créer le formulaire d'ajout de catégorie
        if (JOptionPane.showConfirmDialog(null, message, "Ajouter une catégorie", JOptionPane.OK_CANCEL_OPTION) == JOptionPane.OK_OPTION) {
            String nomDomaine = nomDomaineField.getText();
            String nomIcone = nomIconeField.getText();
            String description = descriptionField.getText();

            // Vérifier que les champs ne sont pas vides
            if (nomDomaine != null && !nomDomaine.trim().isEmpty() &&
                nomIcone != null && !nomIcone.trim().isEmpty() &&
                description != null && !description.trim().isEmpty()) {

                // Créer une nouvelle catégorie
                Categorie nouvelleCategorie = new Categorie(nomDomaine, nomIcone, description);

                // Ajouter la catégorie dans la base de données
                CategorieController.addCategorie(nouvelleCategorie);

                // Mettre à jour la vue pour afficher les catégories actuelles
                updateView();
            } else {
                JOptionPane.showMessageDialog(this, "Veuillez remplir tous les champs.", "Erreur", JOptionPane.ERROR_MESSAGE);
            }
        }
    }

    private void handleDelete(ActionEvent e) {
        int selectedRow = table.getSelectedRow();
        if (selectedRow == -1) {
            JOptionPane.showMessageDialog(this, "Veuillez sélectionner une catégorie à supprimer.", "Erreur", JOptionPane.ERROR_MESSAGE);
            return;
        }

        int categorieId = (int) model.getValueAt(selectedRow, 0);
        int confirm = JOptionPane.showConfirmDialog(this, "Voulez-vous vraiment supprimer cette catégorie ?", "Confirmation", JOptionPane.YES_NO_OPTION);
        if (confirm == JOptionPane.YES_OPTION) {
            CategorieController.deleteCategorie(categorieId);
            updateView();
        }
    }

    // Méthode main pour lancer l'application Swing
    public static void main(String[] args) {
        // Lancer l'interface graphique
        SwingUtilities.invokeLater(CategorieManagerView::new);
    }
}

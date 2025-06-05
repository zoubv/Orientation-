package views;

import controllers.FileController;
import controllers.MetierController;
import controllers.CategorieController;
import models.FichierPDF;
import models.Metier;
import models.Categorie;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.io.File;
import java.nio.file.Files;
import java.util.List;

public class FileManagerView extends JFrame {
    private JTable table;
    private DefaultTableModel model;
    private JComboBox<String> categoryBox;
    private JComboBox<String> viewSelector;
    private List<Categorie> categories;
    private JPanel contentPanel;

    public FileManagerView() {
        setTitle("Gestion Pédagogique - Fichiers PDF et Métiers");
        setSize(800, 500);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLocationRelativeTo(null);

        model = new DefaultTableModel();
        table = new JTable(model);

        // Sélecteur pour afficher fichiers, métiers ou catégories
        viewSelector = new JComboBox<>(new String[]{"Fichiers PDF", "Métiers", "Catégories"});
        viewSelector.addActionListener(e -> updateView());

        JButton addButton = new JButton("Ajouter");
        addButton.addActionListener(this::handleAdd);

        JPanel topPanel = new JPanel();
        topPanel.add(viewSelector);
        topPanel.add(addButton);

        add(topPanel, BorderLayout.NORTH);

        // Conteneur principal pour changer les vues sans fermer la fenêtre
        contentPanel = new JPanel();
        contentPanel.setLayout(new BorderLayout()); // Utilisation de BorderLayout pour mieux organiser les vues
        add(contentPanel, BorderLayout.CENTER);

        updateView(); // Mettre à jour la vue
        setVisible(true);
    }

    // Mise à jour de la vue en fonction de la sélection (Fichiers PDF, Métiers ou Catégories)
    private void updateView() {
        contentPanel.removeAll(); // Supprimer tout contenu existant du panneau de contenu

        // Récupération des catégories de la base de données
        categories = CategorieController.getAllCategories();

        // Si "Fichiers PDF" est sélectionné, afficher les fichiers PDF
        if (viewSelector.getSelectedItem().equals("Fichiers PDF")) {
            displayFileView();
        }
        // Sinon si "Métiers" est sélectionné, afficher les métiers
        else if (viewSelector.getSelectedItem().equals("Métiers")) {
            displayMetierView();
        }
        // Sinon si "Catégories" est sélectionné, afficher la gestion des catégories
        else if (viewSelector.getSelectedItem().equals("Catégories")) {
            displayCategorieView();
        }

        contentPanel.revalidate(); // Revalidate the panel
        contentPanel.repaint(); // Repaint the panel
    }

    // Afficher les fichiers PDF
    private void displayFileView() {
        model.setRowCount(0);
        model.setColumnCount(0);
        model.setColumnIdentifiers(new Object[]{"ID", "Nom", "Description", "ID Catégorie"});
        List<FichierPDF> fichiers = FileController.getAllFiles();
        for (FichierPDF fichier : fichiers) {
            model.addRow(new Object[]{fichier.getId(), fichier.getNom(), fichier.getDescription(), fichier.getIdCategorie()});
        }
        contentPanel.add(new JScrollPane(table), BorderLayout.CENTER); // Ajouter la table des fichiers PDF

        // Ajout des boutons "Modifier" et "Supprimer"
        JPanel actionPanel = new JPanel();
        JButton modifyButton = new JButton("Modifier");
        JButton deleteButton = new JButton("Supprimer");

        modifyButton.addActionListener(this::handleModify);
        deleteButton.addActionListener(this::handleDelete);

        actionPanel.add(modifyButton);
        actionPanel.add(deleteButton);

        contentPanel.add(actionPanel, BorderLayout.SOUTH);
    }

    // Afficher les métiers
    private void displayMetierView() {
        model.setRowCount(0);
        model.setColumnCount(0);
        model.setColumnIdentifiers(new Object[]{"ID", "Nom Métier", "ID Catégorie"});
        List<Metier> metiers = MetierController.getAllMetiers();
        for (Metier metier : metiers) {
            model.addRow(new Object[]{metier.getId(), metier.getNom(), metier.getIdCategorie()});
        }
        contentPanel.add(new JScrollPane(table), BorderLayout.CENTER); // Ajouter la table des métiers

        // Ajout des boutons "Modifier" et "Supprimer"
        JPanel actionPanel = new JPanel();
        JButton modifyButton = new JButton("Modifier");
        JButton deleteButton = new JButton("Supprimer");

        modifyButton.addActionListener(this::handleModify);
        deleteButton.addActionListener(this::handleDelete);

        actionPanel.add(modifyButton);
        actionPanel.add(deleteButton);

        contentPanel.add(actionPanel, BorderLayout.SOUTH);
    }

    // Afficher la gestion des catégories
    private void displayCategorieView() {
        CategorieManagerView categorieManagerView = new CategorieManagerView();
        contentPanel.add(categorieManagerView, BorderLayout.CENTER); // Ajouter la vue de gestion des catégories dans le panneau principal
    }

    // Gestion de l'ajout de fichiers ou métiers en fonction de la sélection
    private void handleAdd(ActionEvent e) {
        if (viewSelector.getSelectedItem().equals("Fichiers PDF")) {
            addFile();
        } else if (viewSelector.getSelectedItem().equals("Métiers")) {
            addMetier();
        } else if (viewSelector.getSelectedItem().equals("Catégories")) {
            addCategorie();
        }
    }

    // Gestion de la modification
    private void handleModify(ActionEvent e) {
        int selectedRow = table.getSelectedRow();
        if (selectedRow != -1) {
            // Récupérer les données de la ligne sélectionnée pour la modification
            if (viewSelector.getSelectedItem().equals("Fichiers PDF")) {
                FichierPDF fichier = FileController.getAllFiles().get(selectedRow);
                // Implémenter la logique de modification pour les fichiers PDF
            } else if (viewSelector.getSelectedItem().equals("Métiers")) {
                Metier metier = MetierController.getAllMetiers().get(selectedRow);
                // Implémenter la logique de modification pour les métiers
            }
        } else {
            JOptionPane.showMessageDialog(this, "Veuillez sélectionner une ligne à modifier.");
        }
    }

    // Gestion de la suppression
    private void handleDelete(ActionEvent e) {
        int selectedRow = table.getSelectedRow();
        if (selectedRow != -1) {
            // Récupérer les données de la ligne sélectionnée pour la suppression
            if (viewSelector.getSelectedItem().equals("Fichiers PDF")) {
                FichierPDF fichier = FileController.getAllFiles().get(selectedRow);
                FileController.deleteFile(fichier.getId());
            } else if (viewSelector.getSelectedItem().equals("Métiers")) {
                Metier metier = MetierController.getAllMetiers().get(selectedRow);
                MetierController.deleteMetier(metier.getId());
            }
            updateView(); // Mettre à jour la vue après la suppression
        } else {
            JOptionPane.showMessageDialog(this, "Veuillez sélectionner une ligne à supprimer.");
        }
    }

    // Ajout d'un fichier PDF
    private void addFile() {
        JTextField nomField = new JTextField();
        JTextField descField = new JTextField();

        // Récupération des catégories de la base de données
        String[] categoryNames = categories.stream().map(Categorie::getNomDomaine).toArray(String[]::new);
        categoryBox = new JComboBox<>(categoryNames);

        JButton fileButton = new JButton("Choisir un fichier PDF");
        final File[] selectedFile = {null};
        fileButton.addActionListener(ev -> {
            JFileChooser fileChooser = new JFileChooser();
            if (fileChooser.showOpenDialog(null) == JFileChooser.APPROVE_OPTION) {
                selectedFile[0] = fileChooser.getSelectedFile();
            }
        });

        Object[] message = {"Nom:", nomField, "Description:", descField, "Catégorie:", categoryBox, fileButton};

        if (JOptionPane.showConfirmDialog(null, message, "Ajouter un fichier", JOptionPane.OK_CANCEL_OPTION) == JOptionPane.OK_OPTION) {
            try {
                byte[] fileData = Files.readAllBytes(selectedFile[0].toPath());
                int idCategorie = categories.get(categoryBox.getSelectedIndex()).getId();
                FileController.addFile(new FichierPDF(0, nomField.getText(), descField.getText(), fileData, idCategorie));
                updateView(); // Mettre à jour la vue après l'ajout
            } catch (Exception ex) {
                ex.printStackTrace();
            }
        }
    }

    // Ajout d'un métier
    private void addMetier() {
        JTextField nomField = new JTextField();
        JTextField iconeField = new JTextField();

        // Récupération des catégories de la base de données
        String[] categoryNames = categories.stream().map(Categorie::getNomDomaine).toArray(String[]::new);
        categoryBox = new JComboBox<>(categoryNames);

        Object[] message = {"Nom Métier:", nomField, "Icône:", iconeField, "Catégorie:", categoryBox};

        if (JOptionPane.showConfirmDialog(null, message, "Ajouter un métier", JOptionPane.OK_CANCEL_OPTION) == JOptionPane.OK_OPTION) {
            int idCategorie = categories.get(categoryBox.getSelectedIndex()).getId();
            MetierController.addMetier(new Metier(0, idCategorie, nomField.getText(), iconeField.getText()));
            updateView(); // Mettre à jour la vue après l'ajout
        }
    }

    // Ajout d'une catégorie
    private void addCategorie() {
        JTextField nomDomaineField = new JTextField();
        JTextField nomIconeField = new JTextField();
        JTextArea descriptionField = new JTextArea();

        Object[] message = {
            "Nom Domaine:", nomDomaineField,
            "Nom Icône:", nomIconeField,
            "Description:", descriptionField
        };

        // Créer la fenêtre de saisie
        if (JOptionPane.showConfirmDialog(null, message, "Ajouter une catégorie", JOptionPane.OK_CANCEL_OPTION) == JOptionPane.OK_OPTION) {
            String nomDomaine = nomDomaineField.getText();
            String nomIcone = nomIconeField.getText();
            String description = descriptionField.getText();

            // Vérifier si les champs ne sont pas vides
            if (nomDomaine != null && !nomDomaine.trim().isEmpty() &&
                nomIcone != null && !nomIcone.trim().isEmpty() &&
                description != null && !description.trim().isEmpty()) {

                // Créer un objet catégorie avec les champs
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
}

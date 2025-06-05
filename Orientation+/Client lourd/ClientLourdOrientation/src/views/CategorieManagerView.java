package views;

import controllers.CategorieController;
import models.Categorie;

import javax.swing.*;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.util.List;

public class CategorieManagerView extends JFrame {
    private JTable table;
    private DefaultTableModel model;
    private JComboBox<String> domainBox;

    public CategorieManagerView() {
        setTitle("Gestion des Catégories");
        setSize(700, 500);
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
        model.setColumnIdentifiers(new Object[]{"ID", "Nom Domaine", "Nom Icône", "Description", "Date d'Ajout"});

        List<Categorie> categories = CategorieController.getAllCategories();
        for (Categorie categorie : categories) {
            model.addRow(new Object[]{
                categorie.getId(),
                categorie.getNomDomaine(),
                categorie.getNomIcone(),
                categorie.getDescription(),
                categorie.getDateAjout()
            });
        }

        // Appliquer un rendu coloré aux lignes
        table.setDefaultRenderer(Object.class, new DefaultTableCellRenderer() {
            @Override
            public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column) {
                Component c = super.getTableCellRendererComponent(table, value, isSelected, hasFocus, row, column);
                if (row % 2 == 0) {
                    c.setBackground(new Color(230, 240, 255)); // Bleu clair
                } else {
                    c.setBackground(Color.WHITE);
                }
                return c;
            }
        });
    }

    private void handleAdd(ActionEvent e) {
        // Récupération des domaines existants
        //List<String> domaines = CategorieController.getAllDomaines();
        //domainBox = new JComboBox<>(domaines.toArray(new String[0]));
        
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

                // Créer une nouvelle catégorie avec la date actuelle
                Categorie nouvelleCategorie = new Categorie(nomDomaine, nomIcone, description);

                // Ajouter la catégorie dans la base de données
                CategorieController.addCategorie(nouvelleCategorie);

                // Mettre à jour la vue
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
        SwingUtilities.invokeLater(CategorieManagerView::new);
    }
}

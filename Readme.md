# Anonymize Customers

This module allows your customers to anonymize their personal data, in compliance with GDPR requirements.

## Installation

### Manually

- Copy the module into `<thelia_root>/local/modules/` directory and be sure that the name of the module is AnonymizeCustomers.
- Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require your-vendor/anonymize-customers-module:~1.0
```

## Usage

Only the logged-in user can anonymize their own data.
In the "Account Deletion" section, the customer can choose to anonymize their data.

Confirmation is required before proceeding with anonymization.
Once confirmed, the customer's data is irreversibly anonymized.

## Hook

account.additional: Adds a new 'Account Deletion' block in the customer account page, containing the anonymization option
account.top: Displays anonymization-related messages at the top of the account page.

# Anonymize Customers

Ce module permet a vos clients d'anonymiser leurs données personnelles, conformément aux exigences du RGPD.

## Installation

### Manually

- Copiez le module dans le répertoire `<racine_thelia>/local/modules/` et assurez-vous que le nom du module est AnonymizeCustomers
- Activez-le dans votre panneau d'administration Thelia.

### Composer

Add it in your main thelia composer.json file

```
composer require your-vendor/anonymize-customers-module:~1.0
```

## Utilisation

Seul l'utilisateur connecté peut anonymiser ses propres données.
Dans la section "Suppression du compte", le client peut choisir d'anonymiser ses données.

Une confirmation est requise avant de procéder à l'anonymisation.
Une fois confirmée, les données du client sont anonymisées de manière irréversible.

## Hook

account.additional : Ajoute un nouveau bloc 'Suppression du compte' dans la page du compte client, contenant l'option d'anonymisation.
account.top : Affiche des messages liés à l'anonymisation en haut de la page du compte.

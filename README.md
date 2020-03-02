# Documentation pr_googlecse #

This is a TYPO3 Extension for using Google Custom Search Engine in combination with Fluid Templates.

## Install the extension ##

### Using TYPO3 extension manager ###

- Open TYPO3 extension manager
- Switch at the top left to "Get extensions"
- Search for pr_googlecse
- Click install

### Using composer ###

Login via SSH, go to your TYPO3 root and run the following command:

`composer require kronova/pr-googlecse`

## Configure the extension ##

### General settings ###

1. Open the extension manager
2. Search for "pr_googlecse"
3. Click on the settings icon on the right
4. Enter your Google API key (you can get it from https://console.developers.google.com/apis/)
5. Enter the key of your custom search (you can get it from https://cse.google.com/cse/)
6. Enable/disable caching if you want
7. Save your changes

### Frontend plugin ###

1. Choose or create the page where the search should be embedded
3. Open the template module
4. Edit the existing or create a new extension template
5. Go to includes and include the pr_googlecse static template
6. Save and exit
7. Open the page view module
8. Add content > Plugins > Google custom search engine
9. Save your changes

Currently there are no more settings. Feel free to add issue tickets for feature requests.

## Customize the extension ##

### Use own templates ###

It´s like many other extensions. You can add your own fluid templates by adding your own paths 
to the TypoScript

Constants:
```
plugin.tx_prgooglecse.view.templateRootPath = EXT:your_ext/Resources/Private/Templates
plugin.tx_prgooglecse.view.layoutRootPath = EXT:your_ext/Resources/Private/Templates
plugin.tx_prgooglecse.view.partialRootPath = EXT:your_ext/Resources/Private/Templates
```

### Override default CSS ###

You can override the following field: `plugin.tx_prgooglecse._CSS_DEFAULT_STYLE`

## Support ##

You can either open an issue ticket if you wan´t to discuss about a feature request, problem or
you can use the contact form on my website https://kronova.net/contact.html for other stuff.

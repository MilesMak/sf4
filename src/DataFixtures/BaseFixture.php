<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager */
    private $manager;
    /** @var Generator */
    protected $faker;
    /** Liste des références aux entités générées par les fixtures */
    private $references = [];

    // Méthode à implémenter par les classes enfant dans laquelle générer des fausses données
    abstract protected function loadData(ObjectManager $manager);

    // Méthode imposée par Doctrine
    public function load(ObjectManager $manager)
    {
        // Enregistrement du manager et instanciation du Faker
        $this->manager = $manager;
        $this->faker = Factory::create('fr_FR');

        // Appel de la méthode pour générer des données
        $this->loadData($manager);
    }

    /**
     * Créer plusieurs entités
     * @param int $count                Nombre d'entités à créer
     * @param string $groupName         Nom associé aux entités générées
     * @param callable $factory         Fonction pour créer une entité
     */
    protected function createMany(int $count, string $groupName, callable $factory)
    {
        // Exécuter $factory $count fois
        for ($i = 0; $i < 50; $i++) {
            // La $factory doit retourner l'entité créée
            $entity = $factory($i);

            if ($entity === null) {
                throw new \LogicException('Tu as oublié de retourner l\'entité !!!');
            }

            // Avertir Doctrine pour l'enregistrement de l'entité
            $this->manager->persist($entity);

            // Ajouter une référence pour l'entité
            $this->addReference(sprintf('%s_%d', $groupName, $i), $entity);
        }
    }

    /**
     * Obtenir une entité aléatoire d'un groupe
     */
    protected function getRandomReference(string $groupName)
    {
        // Si les références ne sont pas présentes dans la propriété :
        if (!isset($this->references[$groupName])) {
            // Récupération des références
            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (strpos($key, $groupName . '_') === 0) {
                    $this->references[$groupName][] = $ref;
                }
            }
        }

        // Retourner une référence aléatoire
        $randomReferenceKey = $this->faker->randomElement($this->references[$groupName]);
        return $this->getReference($randomReferenceKey);
    }
}
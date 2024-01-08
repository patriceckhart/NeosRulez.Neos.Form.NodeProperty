<?php
namespace NeosRulez\Neos\Form\NodeProperty\DataSource;

use Neos\ContentRepository\Domain\Projection\Content\TraversableNodeInterface;
use Neos\ContentRepository\Domain\Service\NodeService;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\PersistenceManagerInterface;
use Neos\Utility\TypeHandling;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;

class PropertyDataSource extends AbstractDataSource
{

    /**
     * @var string
     */
    protected static $identifier = 'neosrulez-neos-form-nodeproperty-nodeproperties';

    /**
     * @Flow\Inject
     * @var NodeService
     */
    protected $nodeService;

    /**
     * @Flow\Inject
     * @var NodeTypeManager
     */
    protected $nodeTypeManager;

    /**
     * @inheritDoc
     * @return array
     */
    public function getData(NodeInterface $node = null, array $arguments = array()): array
    {
        $options = [];
        if($node !== null) {
            foreach ($this->getDocumentNode($node)->getProperties() as $propertyKey => $property) {
                if(!is_array($property)) {
                    $options[] = [
                        'label' => $propertyKey,
                        'value' => $propertyKey
                    ];
                }
            }
        }
        return $options;
    }

    /**
     * @param NodeInterface $node
     * @return NodeInterface
     */
    private function getDocumentNode(NodeInterface $node): NodeInterface
    {
        if($this->nodeService->isNodeOfType($node, $this->nodeTypeManager->getNodeType('Neos.Neos:Document'))) {
            return $node;
        }
        return $this->getDocumentNode($node->getParent());
    }

}
